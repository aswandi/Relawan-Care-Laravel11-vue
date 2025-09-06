import 'package:flutter/material.dart';
import 'package:geolocator/geolocator.dart';
import 'package:geocoding/geocoding.dart';
import '../utils/app_theme.dart';

class LocationWidget extends StatefulWidget {
  final Position? currentLocation;
  final Function(Position) onLocationUpdate;

  const LocationWidget({
    Key? key,
    required this.currentLocation,
    required this.onLocationUpdate,
  }) : super(key: key);

  @override
  _LocationWidgetState createState() => _LocationWidgetState();
}

class _LocationWidgetState extends State<LocationWidget>
    with SingleTickerProviderStateMixin {
  late AnimationController _animationController;
  late Animation<double> _pulseAnimation;

  String? _locationAddress;
  bool _isGettingAddress = false;
  bool _isUpdatingLocation = false;

  @override
  void initState() {
    super.initState();

    _animationController = AnimationController(
      duration: const Duration(seconds: 2),
      vsync: this,
    );

    _pulseAnimation = Tween<double>(
      begin: 1.0,
      end: 1.2,
    ).animate(CurvedAnimation(
      parent: _animationController,
      curve: Curves.easeInOut,
    ));

    _animationController.repeat(reverse: true);

    if (widget.currentLocation != null) {
      _getAddressFromCoordinates();
    }
  }

  @override
  void dispose() {
    _animationController.dispose();
    super.dispose();
  }

  @override
  void didUpdateWidget(LocationWidget oldWidget) {
    super.didUpdateWidget(oldWidget);

    if (widget.currentLocation != oldWidget.currentLocation) {
      if (widget.currentLocation != null) {
        _getAddressFromCoordinates();
      } else {
        setState(() {
          _locationAddress = null;
        });
      }
    }
  }

  Future<void> _getAddressFromCoordinates() async {
    if (widget.currentLocation == null) return;

    setState(() {
      _isGettingAddress = true;
    });

    try {
      List<Placemark> placemarks = await placemarkFromCoordinates(
        widget.currentLocation!.latitude,
        widget.currentLocation!.longitude,
      );

      if (placemarks.isNotEmpty) {
        final place = placemarks.first;
        final address = [
          place.street,
          place.subLocality,
          place.locality,
          place.subAdministrativeArea,
          place.administrativeArea,
        ]
            .where((component) => component != null && component.isNotEmpty)
            .join(', ');

        setState(() {
          _locationAddress =
              address.isNotEmpty ? address : 'Alamat tidak ditemukan';
          _isGettingAddress = false;
        });
      } else {
        setState(() {
          _locationAddress = 'Alamat tidak ditemukan';
          _isGettingAddress = false;
        });
      }
    } catch (e) {
      setState(() {
        _locationAddress = 'Gagal mendapatkan alamat';
        _isGettingAddress = false;
      });
    }
  }

  Future<void> _updateLocation() async {
    setState(() {
      _isUpdatingLocation = true;
    });

    try {
      // Check permissions
      LocationPermission permission = await Geolocator.checkPermission();
      if (permission == LocationPermission.denied) {
        permission = await Geolocator.requestPermission();
      }

      if (permission == LocationPermission.deniedForever) {
        _showPermissionDialog();
        setState(() {
          _isUpdatingLocation = false;
        });
        return;
      }

      if (permission == LocationPermission.denied) {
        _showErrorSnackBar('Akses lokasi ditolak');
        setState(() {
          _isUpdatingLocation = false;
        });
        return;
      }

      // Get current position
      Position position = await Geolocator.getCurrentPosition(
        desiredAccuracy: LocationAccuracy.high,
      );

      widget.onLocationUpdate(position);
      _showSuccessSnackBar('Lokasi berhasil diperbarui');

      setState(() {
        _isUpdatingLocation = false;
      });
    } catch (e) {
      _showErrorSnackBar('Gagal mendapatkan lokasi: ${e.toString()}');
      setState(() {
        _isUpdatingLocation = false;
      });
    }
  }

  void _showPermissionDialog() {
    showDialog(
      context: context,
      builder: (context) => AlertDialog(
        title: const Text('Izin Lokasi Diperlukan'),
        content: const Text(
          'Aplikasi memerlukan izin akses lokasi untuk mencatat posisi GPS aktivitas. '
          'Silakan aktifkan izin lokasi di pengaturan aplikasi.',
        ),
        actions: [
          TextButton(
            onPressed: () => Navigator.pop(context),
            child: const Text('Batal'),
          ),
          ElevatedButton(
            onPressed: () {
              Navigator.pop(context);
              Geolocator.openAppSettings();
            },
            child: const Text('Buka Pengaturan'),
          ),
        ],
      ),
    );
  }

  void _showSuccessSnackBar(String message) {
    ScaffoldMessenger.of(context).showSnackBar(
      SnackBar(
        content: Row(
          children: [
            const Icon(Icons.check_circle, color: Colors.white),
            const SizedBox(width: 8),
            Text(message),
          ],
        ),
        backgroundColor: AppTheme.accentColor,
        duration: const Duration(seconds: 2),
      ),
    );
  }

  void _showErrorSnackBar(String message) {
    ScaffoldMessenger.of(context).showSnackBar(
      SnackBar(
        content: Row(
          children: [
            const Icon(Icons.error_outline, color: Colors.white),
            const SizedBox(width: 8),
            Expanded(child: Text(message)),
          ],
        ),
        backgroundColor: AppTheme.dangerColor,
        duration: const Duration(seconds: 3),
      ),
    );
  }

  @override
  Widget build(BuildContext context) {
    return Container(
      decoration: AppTheme.cardDecoration(),
      padding: const EdgeInsets.all(16),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Row(
            mainAxisAlignment: MainAxisAlignment.spaceBetween,
            children: [
              const Text(
                'Lokasi GPS',
                style: TextStyle(
                  fontSize: 16,
                  fontWeight: FontWeight.w600,
                  color: AppTheme.textPrimaryColor,
                ),
              ),
              if (widget.currentLocation != null)
                AnimatedBuilder(
                  animation: _animationController,
                  builder: (context, child) {
                    return Transform.scale(
                      scale: _pulseAnimation.value,
                      child: const Icon(
                        Icons.gps_fixed,
                        color: AppTheme.accentColor,
                        size: 20,
                      ),
                    );
                  },
                ),
            ],
          ),

          const SizedBox(height: 12),

          if (widget.currentLocation == null)
            _buildNoLocationState()
          else
            _buildLocationInfo(),

          const SizedBox(height: 16),

          // Update Location Button
          SizedBox(
            width: double.infinity,
            child: ElevatedButton.icon(
              onPressed: _isUpdatingLocation ? null : _updateLocation,
              icon: _isUpdatingLocation
                  ? const SizedBox(
                      width: 16,
                      height: 16,
                      child: CircularProgressIndicator(
                        color: Colors.white,
                        strokeWidth: 2,
                      ),
                    )
                  : const Icon(Icons.my_location),
              label: Text(
                _isUpdatingLocation
                    ? 'Memperbarui Lokasi...'
                    : 'Perbarui Lokasi',
              ),
              style: ElevatedButton.styleFrom(
                backgroundColor: widget.currentLocation != null
                    ? AppTheme.primaryColor
                    : AppTheme.accentColor,
              ),
            ),
          ),

          const SizedBox(height: 8),

          const Text(
            'Pastikan GPS aktif dan lokasi akurat sebelum melanjutkan',
            style: TextStyle(
              fontSize: 11,
              color: AppTheme.textSecondaryColor,
              fontStyle: FontStyle.italic,
            ),
            textAlign: TextAlign.center,
          ),
        ],
      ),
    );
  }

  Widget _buildNoLocationState() {
    return Container(
      width: double.infinity,
      padding: const EdgeInsets.all(20),
      decoration: BoxDecoration(
        color: AppTheme.warningColor.withOpacity(0.1),
        borderRadius: BorderRadius.circular(8),
        border: Border.all(
          color: AppTheme.warningColor.withOpacity(0.3),
        ),
      ),
      child: const Column(
        children: [
          Icon(
            Icons.location_off,
            color: AppTheme.warningColor,
            size: 48,
          ),
          SizedBox(height: 12),
          Text(
            'Lokasi Belum Tersedia',
            style: TextStyle(
              fontSize: 16,
              fontWeight: FontWeight.w600,
              color: AppTheme.warningColor,
            ),
          ),
          SizedBox(height: 8),
          Text(
            'Tap tombol di bawah untuk mendapatkan lokasi GPS saat ini',
            style: TextStyle(
              fontSize: 12,
              color: AppTheme.textSecondaryColor,
            ),
            textAlign: TextAlign.center,
          ),
        ],
      ),
    );
  }

  Widget _buildLocationInfo() {
    return Column(
      children: [
        // GPS Coordinates
        Container(
          width: double.infinity,
          padding: const EdgeInsets.all(12),
          decoration: BoxDecoration(
            color: AppTheme.accentColor.withOpacity(0.1),
            borderRadius: BorderRadius.circular(8),
            border: Border.all(
              color: AppTheme.accentColor.withOpacity(0.3),
            ),
          ),
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              const Row(
                children: [
                  Icon(
                    Icons.gps_fixed,
                    color: AppTheme.accentColor,
                    size: 16,
                  ),
                  SizedBox(width: 6),
                  Text(
                    'Koordinat GPS',
                    style: TextStyle(
                      fontSize: 12,
                      fontWeight: FontWeight.w600,
                      color: AppTheme.accentColor,
                    ),
                  ),
                ],
              ),
              const SizedBox(height: 6),
              Text(
                'Lat: ${widget.currentLocation!.latitude.toStringAsFixed(6)}',
                style: const TextStyle(
                  fontSize: 13,
                  color: AppTheme.textPrimaryColor,
                  fontFamily: 'monospace',
                ),
              ),
              Text(
                'Lng: ${widget.currentLocation!.longitude.toStringAsFixed(6)}',
                style: const TextStyle(
                  fontSize: 13,
                  color: AppTheme.textPrimaryColor,
                  fontFamily: 'monospace',
                ),
              ),
            ],
          ),
        ),

        const SizedBox(height: 12),

        // Address Information
        Container(
          width: double.infinity,
          padding: const EdgeInsets.all(12),
          decoration: BoxDecoration(
            color: AppTheme.backgroundColor,
            borderRadius: BorderRadius.circular(8),
            border: Border.all(color: AppTheme.borderColor),
          ),
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              Row(
                children: [
                  const Icon(
                    Icons.location_on,
                    color: AppTheme.primaryColor,
                    size: 16,
                  ),
                  const SizedBox(width: 6),
                  const Text(
                    'Alamat',
                    style: TextStyle(
                      fontSize: 12,
                      fontWeight: FontWeight.w600,
                      color: AppTheme.primaryColor,
                    ),
                  ),
                  if (_isGettingAddress) ...[
                    const SizedBox(width: 8),
                    const SizedBox(
                      width: 12,
                      height: 12,
                      child: CircularProgressIndicator(
                        color: AppTheme.primaryColor,
                        strokeWidth: 1.5,
                      ),
                    ),
                  ],
                ],
              ),
              const SizedBox(height: 6),
              Text(
                _isGettingAddress
                    ? 'Mendapatkan alamat...'
                    : (_locationAddress ?? 'Alamat tidak tersedia'),
                style: const TextStyle(
                  fontSize: 13,
                  color: AppTheme.textPrimaryColor,
                ),
              ),
            ],
          ),
        ),

        const SizedBox(height: 12),

        // Location Accuracy
        Row(
          children: [
            Icon(
              Icons.radar,
              color: _getAccuracyColor(),
              size: 16,
            ),
            const SizedBox(width: 6),
            Text(
              'Akurasi: ${widget.currentLocation!.accuracy.toStringAsFixed(1)}m',
              style: TextStyle(
                fontSize: 12,
                color: _getAccuracyColor(),
                fontWeight: FontWeight.w500,
              ),
            ),
            const SizedBox(width: 8),
            Text(
              _getAccuracyLabel(),
              style: TextStyle(
                fontSize: 11,
                color: _getAccuracyColor(),
                fontWeight: FontWeight.w600,
              ),
            ),
          ],
        ),
      ],
    );
  }

  Color _getAccuracyColor() {
    if (widget.currentLocation == null) return AppTheme.textSecondaryColor;

    final accuracy = widget.currentLocation!.accuracy;
    if (accuracy <= 5) return AppTheme.accentColor;
    if (accuracy <= 10) return AppTheme.warningColor;
    return AppTheme.dangerColor;
  }

  String _getAccuracyLabel() {
    if (widget.currentLocation == null) return '';

    final accuracy = widget.currentLocation!.accuracy;
    if (accuracy <= 5) return 'Sangat Baik';
    if (accuracy <= 10) return 'Baik';
    return 'Kurang Baik';
  }
}
