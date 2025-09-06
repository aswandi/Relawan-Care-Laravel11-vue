import 'package:flutter/material.dart';
import 'package:provider/provider.dart';
import 'package:geolocator/geolocator.dart';
import 'dart:io';

import '../services/auth_service.dart';
import '../services/activity_service.dart';
import '../models/beneficiary.dart';
import '../utils/app_theme.dart';
import '../widgets/beneficiary_search_widget.dart';
import '../widgets/aid_selector_widget.dart';
import '../widgets/photo_picker_widget.dart';
import '../widgets/location_widget.dart';

class AddActivityScreen extends StatefulWidget {
  const AddActivityScreen({super.key});

  @override
  _AddActivityScreenState createState() => _AddActivityScreenState();
}

class _AddActivityScreenState extends State<AddActivityScreen>
    with TickerProviderStateMixin {
  late AnimationController _animationController;
  late AnimationController _fabAnimationController;
  late Animation<double> _fadeAnimation;
  late Animation<Offset> _slideAnimation;
  late Animation<double> _fabScaleAnimation;

  final _formKey = GlobalKey<FormState>();
  final _notesController = TextEditingController();
  final _activityService = ActivityService();

  Beneficiary? _selectedBeneficiary;
  List<Map<String, dynamic>> _selectedAids = [];
  List<File> _selectedPhotos = [];
  Position? _currentLocation;
  final DateTime _visitDate = DateTime.now();
  
  bool _isLoading = false;
  String? _error;
  int _currentStep = 0;

  @override
  void initState() {
    super.initState();
    
    _animationController = AnimationController(
      duration: const Duration(milliseconds: 800),
      vsync: this,
    );

    _fabAnimationController = AnimationController(
      duration: const Duration(milliseconds: 300),
      vsync: this,
    );

    _fadeAnimation = Tween<double>(
      begin: 0.0,
      end: 1.0,
    ).animate(CurvedAnimation(
      parent: _animationController,
      curve: Curves.easeInOut,
    ));

    _slideAnimation = Tween<Offset>(
      begin: const Offset(0, 0.5),
      end: Offset.zero,
    ).animate(CurvedAnimation(
      parent: _animationController,
      curve: Curves.easeOutCubic,
    ));

    _fabScaleAnimation = Tween<double>(
      begin: 0.0,
      end: 1.0,
    ).animate(CurvedAnimation(
      parent: _fabAnimationController,
      curve: Curves.elasticOut,
    ));

    _animationController.forward();
    _fabAnimationController.forward();
    _getCurrentLocation();
  }

  @override
  void dispose() {
    _animationController.dispose();
    _fabAnimationController.dispose();
    _notesController.dispose();
    super.dispose();
  }

  Future<void> _getCurrentLocation() async {
    try {
      // Check permissions
      LocationPermission permission = await Geolocator.checkPermission();
      if (permission == LocationPermission.denied) {
        permission = await Geolocator.requestPermission();
      }

      if (permission == LocationPermission.deniedForever) {
        _showErrorDialog('Akses lokasi diperlukan untuk mencatat aktivitas');
        return;
      }

      if (permission == LocationPermission.denied) {
        _showErrorDialog('Akses lokasi ditolak');
        return;
      }

      // Get current position
      Position position = await Geolocator.getCurrentPosition(
        desiredAccuracy: LocationAccuracy.high,
      );

      setState(() {
        _currentLocation = position;
      });
    } catch (e) {
      _showErrorDialog('Gagal mendapatkan lokasi: ${e.toString()}');
    }
  }

  Future<void> _submitActivity() async {
    if (!_formKey.currentState!.validate()) return;
    if (_selectedBeneficiary == null) {
      _showErrorDialog('Pilih penerima bantuan terlebih dahulu');
      return;
    }
    if (_selectedAids.isEmpty) {
      _showErrorDialog('Tambahkan minimal satu jenis bantuan');
      return;
    }
    if (_selectedPhotos.isEmpty) {
      _showErrorDialog('Tambahkan minimal satu foto dokumentasi');
      return;
    }
    if (_currentLocation == null) {
      _showErrorDialog('Lokasi belum tersedia, pastikan GPS aktif');
      return;
    }

    setState(() {
      _isLoading = true;
      _error = null;
    });

    try {
      final authService = Provider.of<AuthService>(context, listen: false);
      
      final success = await _activityService.createActivity(
        volunteerId: authService.currentVolunteer!.id,
        beneficiaryId: _selectedBeneficiary!.id,
        visitDate: _visitDate,
        latitude: _currentLocation!.latitude,
        longitude: _currentLocation!.longitude,
        notes: _notesController.text.trim().isEmpty ? null : _notesController.text.trim(),
        aids: _selectedAids,
        photos: _selectedPhotos,
      );

      if (success) {
        _showSuccessDialog();
      } else {
        setState(() {
          _error = 'Gagal menyimpan aktivitas';
          _isLoading = false;
        });
      }
    } catch (e) {
      setState(() {
        _error = e.toString();
        _isLoading = false;
      });
    }
  }

  void _showSuccessDialog() {
    showDialog(
      context: context,
      barrierDismissible: false,
      builder: (context) => AlertDialog(
        title: const Row(
          children: [
            Icon(Icons.check_circle, color: AppTheme.accentColor),
            SizedBox(width: 8),
            Text('Berhasil!'),
          ],
        ),
        content: const Text('Aktivitas berhasil disimpan dan akan segera disinkronkan.'),
        actions: [
          ElevatedButton(
            onPressed: () {
              Navigator.pop(context); // Close dialog
              Navigator.pop(context, true); // Return to dashboard with success flag
            },
            child: const Text('OK'),
          ),
        ],
      ),
    );
  }

  void _showErrorDialog(String message) {
    showDialog(
      context: context,
      builder: (context) => AlertDialog(
        title: const Row(
          children: [
            Icon(Icons.error_outline, color: AppTheme.dangerColor),
            SizedBox(width: 8),
            Text('Error'),
          ],
        ),
        content: Text(message),
        actions: [
          TextButton(
            onPressed: () => Navigator.pop(context),
            child: const Text('OK'),
          ),
        ],
      ),
    );
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: AppTheme.backgroundColor,
      appBar: AppBar(
        title: const Text('Tambah Aktivitas'),
        elevation: 0,
        actions: [
          if (_currentLocation != null)
            IconButton(
              icon: const Icon(Icons.my_location),
              onPressed: _getCurrentLocation,
              tooltip: 'Update Lokasi',
            ),
        ],
      ),
      body: AnimatedBuilder(
        animation: _animationController,
        builder: (context, child) {
          return FadeTransition(
            opacity: _fadeAnimation,
            child: SlideTransition(
              position: _slideAnimation,
              child: Column(
                children: [
                  _buildProgressIndicator(),
                  Expanded(
                    child: _buildStepContent(),
                  ),
                  _buildNavigationButtons(),
                ],
              ),
            ),
          );
        },
      ),
      floatingActionButton: _currentStep == 4 ? AnimatedBuilder(
        animation: _fabAnimationController,
        builder: (context, child) {
          return Transform.scale(
            scale: _fabScaleAnimation.value,
            child: FloatingActionButton.extended(
              onPressed: _isLoading ? null : _submitActivity,
              backgroundColor: AppTheme.accentColor,
              icon: _isLoading 
                  ? const SizedBox(
                      width: 20,
                      height: 20,
                      child: CircularProgressIndicator(
                        color: Colors.white,
                        strokeWidth: 2,
                      ),
                    )
                  : const Icon(Icons.save),
              label: Text(_isLoading ? 'Menyimpan...' : 'Simpan Aktivitas'),
            ),
          );
        },
      ) : null,
    );
  }

  Widget _buildProgressIndicator() {
    return Container(
      padding: const EdgeInsets.all(20),
      child: Row(
        children: List.generate(5, (index) {
          return Expanded(
            child: Container(
              margin: const EdgeInsets.symmetric(horizontal: 2),
              height: 4,
              decoration: BoxDecoration(
                color: index <= _currentStep 
                    ? AppTheme.primaryColor 
                    : AppTheme.borderColor,
                borderRadius: BorderRadius.circular(2),
              ),
            ),
          );
        }),
      ),
    );
  }

  Widget _buildStepContent() {
    switch (_currentStep) {
      case 0:
        return _buildBeneficiaryStep();
      case 1:
        return _buildAidSelectionStep();
      case 2:
        return _buildPhotoStep();
      case 3:
        return _buildLocationStep();
      case 4:
        return _buildReviewStep();
      default:
        return Container();
    }
  }

  Widget _buildBeneficiaryStep() {
    return SingleChildScrollView(
      padding: const EdgeInsets.all(20),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          _buildStepHeader(
            'Langkah 1: Pilih Penerima Bantuan',
            'Cari penerima bantuan berdasarkan NIK',
          ),
          const SizedBox(height: 20),
          BeneficiarySearchWidget(
            onBeneficiarySelected: (beneficiary) {
              setState(() {
                _selectedBeneficiary = beneficiary;
              });
            },
            selectedBeneficiary: _selectedBeneficiary,
          ),
        ],
      ),
    );
  }

  Widget _buildAidSelectionStep() {
    return SingleChildScrollView(
      padding: const EdgeInsets.all(20),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          _buildStepHeader(
            'Langkah 2: Pilih Bantuan',
            'Pilih jenis dan jumlah bantuan yang diberikan',
          ),
          const SizedBox(height: 20),
          AidSelectorWidget(
            selectedAids: _selectedAids,
            onAidsChanged: (aids) {
              setState(() {
                _selectedAids = aids;
              });
            },
          ),
        ],
      ),
    );
  }

  Widget _buildPhotoStep() {
    return SingleChildScrollView(
      padding: const EdgeInsets.all(20),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          _buildStepHeader(
            'Langkah 3: Dokumentasi Foto',
            'Ambil foto sebagai dokumentasi kegiatan',
          ),
          const SizedBox(height: 20),
          PhotoPickerWidget(
            selectedPhotos: _selectedPhotos,
            onPhotosChanged: (photos) {
              setState(() {
                _selectedPhotos = photos;
              });
            },
            maxPhotos: 5,
          ),
        ],
      ),
    );
  }

  Widget _buildLocationStep() {
    return SingleChildScrollView(
      padding: const EdgeInsets.all(20),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          _buildStepHeader(
            'Langkah 4: Verifikasi Lokasi',
            'Pastikan lokasi GPS sudah akurat',
          ),
          const SizedBox(height: 20),
          LocationWidget(
            currentLocation: _currentLocation,
            onLocationUpdate: (location) {
              setState(() {
                _currentLocation = location;
              });
            },
          ),
          const SizedBox(height: 20),
          TextFormField(
            controller: _notesController,
            decoration: const InputDecoration(
              labelText: 'Catatan (Opsional)',
              hintText: 'Tambahkan catatan tentang kegiatan ini...',
              prefixIcon: Icon(Icons.note_alt_outlined),
            ),
            maxLines: 3,
            maxLength: 500,
          ),
        ],
      ),
    );
  }

  Widget _buildReviewStep() {
    return SingleChildScrollView(
      padding: const EdgeInsets.all(20),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          _buildStepHeader(
            'Langkah 5: Review & Simpan',
            'Periksa kembali semua data sebelum menyimpan',
          ),
          const SizedBox(height: 20),
          _buildReviewCard(),
          if (_error != null) ...[
            const SizedBox(height: 16),
            Container(
              padding: const EdgeInsets.all(12),
              decoration: BoxDecoration(
                color: AppTheme.dangerColor.withOpacity(0.1),
                borderRadius: BorderRadius.circular(8),
                border: Border.all(color: AppTheme.dangerColor.withOpacity(0.3)),
              ),
              child: Row(
                children: [
                  const Icon(Icons.error_outline, color: AppTheme.dangerColor),
                  const SizedBox(width: 8),
                  Expanded(
                    child: Text(
                      _error!,
                      style: const TextStyle(color: AppTheme.dangerColor),
                    ),
                  ),
                ],
              ),
            ),
          ],
        ],
      ),
    );
  }

  Widget _buildReviewCard() {
    return Container(
      decoration: AppTheme.cardDecoration(),
      padding: const EdgeInsets.all(16),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          const Text(
            'Ringkasan Aktivitas',
            style: TextStyle(
              fontSize: 18,
              fontWeight: FontWeight.bold,
              color: AppTheme.textPrimaryColor,
            ),
          ),
          const SizedBox(height: 16),
          
          // Beneficiary Info
          _buildReviewItem(
            'Penerima Bantuan',
            _selectedBeneficiary?.name ?? '-',
            Icons.person,
          ),
          _buildReviewItem(
            'NIK',
            _selectedBeneficiary?.nik ?? '-',
            Icons.credit_card,
          ),
          
          // Aid Info
          _buildReviewItem(
            'Jumlah Bantuan',
            '${_selectedAids.length} jenis bantuan',
            Icons.card_giftcard,
          ),
          
          // Photo Info
          _buildReviewItem(
            'Dokumentasi',
            '${_selectedPhotos.length} foto',
            Icons.camera_alt,
          ),
          
          // Location Info
          _buildReviewItem(
            'Lokasi',
            _currentLocation != null 
                ? 'GPS: ${_currentLocation!.latitude.toStringAsFixed(6)}, ${_currentLocation!.longitude.toStringAsFixed(6)}'
                : 'Lokasi tidak tersedia',
            Icons.location_on,
          ),
          
          // Notes
          if (_notesController.text.trim().isNotEmpty)
            _buildReviewItem(
              'Catatan',
              _notesController.text.trim(),
              Icons.note_alt,
            ),
        ],
      ),
    );
  }

  Widget _buildReviewItem(String title, String value, IconData icon) {
    return Padding(
      padding: const EdgeInsets.only(bottom: 12),
      child: Row(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Icon(icon, color: AppTheme.primaryColor, size: 20),
          const SizedBox(width: 12),
          Expanded(
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                Text(
                  title,
                  style: const TextStyle(
                    fontSize: 12,
                    color: AppTheme.textSecondaryColor,
                  ),
                ),
                Text(
                  value,
                  style: const TextStyle(
                    fontSize: 14,
                    fontWeight: FontWeight.w500,
                    color: AppTheme.textPrimaryColor,
                  ),
                ),
              ],
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildStepHeader(String title, String subtitle) {
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        Text(
          title,
          style: const TextStyle(
            fontSize: 20,
            fontWeight: FontWeight.bold,
            color: AppTheme.textPrimaryColor,
          ),
        ),
        const SizedBox(height: 8),
        Text(
          subtitle,
          style: const TextStyle(
            fontSize: 14,
            color: AppTheme.textSecondaryColor,
          ),
        ),
      ],
    );
  }

  Widget _buildNavigationButtons() {
    return Container(
      padding: const EdgeInsets.all(20),
      decoration: BoxDecoration(
        color: Colors.white,
        boxShadow: [
          BoxShadow(
            color: Colors.black.withOpacity(0.05),
            blurRadius: 10,
            offset: const Offset(0, -2),
          ),
        ],
      ),
      child: Row(
        children: [
          if (_currentStep > 0)
            Expanded(
              child: OutlinedButton(
                onPressed: () {
                  setState(() {
                    _currentStep--;
                  });
                },
                child: const Text('Sebelumnya'),
              ),
            ),
          if (_currentStep > 0) const SizedBox(width: 12),
          if (_currentStep < 4)
            Expanded(
              flex: _currentStep == 0 ? 1 : 1,
              child: ElevatedButton(
                onPressed: _canProceedToNextStep() ? () {
                  setState(() {
                    _currentStep++;
                  });
                } : null,
                child: Text(_currentStep == 4 ? 'Simpan' : 'Selanjutnya'),
              ),
            ),
        ],
      ),
    );
  }

  bool _canProceedToNextStep() {
    switch (_currentStep) {
      case 0:
        return _selectedBeneficiary != null;
      case 1:
        return _selectedAids.isNotEmpty;
      case 2:
        return _selectedPhotos.isNotEmpty;
      case 3:
        return _currentLocation != null;
      case 4:
        return true;
      default:
        return false;
    }
  }
}