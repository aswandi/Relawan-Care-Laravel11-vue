import 'package:flutter/material.dart';
import '../models/beneficiary.dart';
import '../services/activity_service.dart';
import '../utils/app_theme.dart';

class BeneficiarySearchWidget extends StatefulWidget {
  final Function(Beneficiary?) onBeneficiarySelected;
  final Beneficiary? selectedBeneficiary;

  const BeneficiarySearchWidget({
    Key? key,
    required this.onBeneficiarySelected,
    this.selectedBeneficiary,
  }) : super(key: key);

  @override
  _BeneficiarySearchWidgetState createState() =>
      _BeneficiarySearchWidgetState();
}

class _BeneficiarySearchWidgetState extends State<BeneficiarySearchWidget>
    with SingleTickerProviderStateMixin {
  final _nikController = TextEditingController();
  final _activityService = ActivityService();

  late AnimationController _animationController;
  late Animation<double> _scaleAnimation;

  bool _isLoading = false;
  String? _error;

  @override
  void initState() {
    super.initState();

    _animationController = AnimationController(
      duration: const Duration(milliseconds: 400),
      vsync: this,
    );

    _scaleAnimation = Tween<double>(
      begin: 0.0,
      end: 1.0,
    ).animate(CurvedAnimation(
      parent: _animationController,
      curve: Curves.bounceOut,
    ));

    if (widget.selectedBeneficiary != null) {
      _nikController.text = widget.selectedBeneficiary!.nik;
      _animationController.forward();
    }
  }

  @override
  void dispose() {
    _animationController.dispose();
    _nikController.dispose();
    super.dispose();
  }

  Future<void> _searchBeneficiary() async {
    final nik = _nikController.text.trim();
    if (nik.length < 16) {
      setState(() {
        _error = 'NIK harus 16 digit';
      });
      return;
    }

    setState(() {
      _isLoading = true;
      _error = null;
    });

    try {
      final beneficiary = await _activityService.searchBeneficiaryByNik(nik);

      if (beneficiary != null) {
        widget.onBeneficiarySelected(beneficiary);
        _animationController.forward();
        setState(() {
          _isLoading = false;
        });
      } else {
        setState(() {
          _isLoading = false;
          _error = 'NIK tidak ditemukan dalam database';
        });
        widget.onBeneficiarySelected(null);
        _animationController.reverse();
      }
    } catch (e) {
      setState(() {
        _isLoading = false;
        _error = e.toString();
      });
      widget.onBeneficiarySelected(null);
      _animationController.reverse();
    }
  }

  void _clearSearch() {
    _nikController.clear();
    widget.onBeneficiarySelected(null);
    _animationController.reverse();
    setState(() {
      _error = null;
    });
  }

  @override
  Widget build(BuildContext context) {
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        _buildSearchField(),
        const SizedBox(height: 16),
        if (_error != null) _buildErrorMessage(),
        if (widget.selectedBeneficiary != null) _buildBeneficiaryCard(),
      ],
    );
  }

  Widget _buildSearchField() {
    return Container(
      decoration: AppTheme.cardDecoration(),
      padding: const EdgeInsets.all(16),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          const Text(
            'Cari Penerima Bantuan',
            style: TextStyle(
              fontSize: 16,
              fontWeight: FontWeight.w600,
              color: AppTheme.textPrimaryColor,
            ),
          ),
          const SizedBox(height: 12),
          Row(
            children: [
              Expanded(
                child: TextFormField(
                  controller: _nikController,
                  keyboardType: TextInputType.number,
                  maxLength: 16,
                  decoration: InputDecoration(
                    labelText: 'Nomor Induk Kependudukan (NIK)',
                    hintText: 'Masukkan 16 digit NIK',
                    prefixIcon: const Icon(Icons.credit_card),
                    suffixIcon: _nikController.text.isNotEmpty
                        ? IconButton(
                            icon: const Icon(Icons.clear),
                            onPressed: _clearSearch,
                          )
                        : null,
                    counterText: '',
                  ),
                  onChanged: (value) {
                    setState(() {
                      if (value.isEmpty) {
                        _clearSearch();
                      }
                    });
                  },
                  validator: (value) {
                    if (value == null || value.isEmpty) {
                      return 'NIK wajib diisi';
                    }
                    if (value.length != 16) {
                      return 'NIK harus 16 digit';
                    }
                    return null;
                  },
                ),
              ),
              const SizedBox(width: 12),
              SizedBox(
                height: 56,
                child: ElevatedButton(
                  onPressed: _isLoading ? null : _searchBeneficiary,
                  style: ElevatedButton.styleFrom(
                    backgroundColor: AppTheme.primaryColor,
                    padding: const EdgeInsets.symmetric(horizontal: 20),
                  ),
                  child: _isLoading
                      ? const SizedBox(
                          width: 20,
                          height: 20,
                          child: CircularProgressIndicator(
                            color: Colors.white,
                            strokeWidth: 2,
                          ),
                        )
                      : const Icon(Icons.search),
                ),
              ),
            ],
          ),
          const SizedBox(height: 8),
          const Text(
            'NIK harus sesuai dengan yang terdaftar dalam database penerima bantuan',
            style: TextStyle(
              fontSize: 12,
              color: AppTheme.textSecondaryColor,
              fontStyle: FontStyle.italic,
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildErrorMessage() {
    return Container(
      margin: const EdgeInsets.only(bottom: 16),
      padding: const EdgeInsets.all(12),
      decoration: BoxDecoration(
        color: AppTheme.dangerColor.withOpacity(0.1),
        borderRadius: BorderRadius.circular(8),
        border: Border.all(
          color: AppTheme.dangerColor.withOpacity(0.3),
        ),
      ),
      child: Row(
        children: [
          const Icon(
            Icons.error_outline,
            color: AppTheme.dangerColor,
            size: 20,
          ),
          const SizedBox(width: 8),
          Expanded(
            child: Text(
              _error!,
              style: const TextStyle(
                color: AppTheme.dangerColor,
                fontSize: 14,
                fontWeight: FontWeight.w500,
              ),
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildBeneficiaryCard() {
    return AnimatedBuilder(
      animation: _animationController,
      builder: (context, child) {
        return Transform.scale(
          scale: _scaleAnimation.value,
          child: Container(
            decoration: AppTheme.cardDecoration(
              border: Border.all(
                color: AppTheme.accentColor.withOpacity(0.3),
                width: 1,
              ),
            ),
            padding: const EdgeInsets.all(16),
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                Row(
                  children: [
                    Container(
                      padding: const EdgeInsets.all(8),
                      decoration: BoxDecoration(
                        color: AppTheme.accentColor.withOpacity(0.1),
                        borderRadius: BorderRadius.circular(8),
                      ),
                      child: const Icon(
                        Icons.person_outline,
                        color: AppTheme.accentColor,
                        size: 24,
                      ),
                    ),
                    const SizedBox(width: 12),
                    Expanded(
                      child: Column(
                        crossAxisAlignment: CrossAxisAlignment.start,
                        children: [
                          const Text(
                            'Penerima Bantuan Ditemukan',
                            style: TextStyle(
                              fontSize: 12,
                              color: AppTheme.accentColor,
                              fontWeight: FontWeight.w600,
                            ),
                          ),
                          Text(
                            widget.selectedBeneficiary!.name,
                            style: const TextStyle(
                              fontSize: 18,
                              fontWeight: FontWeight.bold,
                              color: AppTheme.textPrimaryColor,
                            ),
                          ),
                        ],
                      ),
                    ),
                    IconButton(
                      icon: const Icon(Icons.close,
                          color: AppTheme.textSecondaryColor),
                      onPressed: _clearSearch,
                      tooltip: 'Hapus Pilihan',
                    ),
                  ],
                ),
                const SizedBox(height: 16),
                const Divider(color: AppTheme.borderColor),
                const SizedBox(height: 12),

                // Personal Info
                _buildInfoRow(
                  'NIK',
                  widget.selectedBeneficiary!.nik,
                  Icons.credit_card,
                ),
                _buildInfoRow(
                  'Nomor HP',
                  widget.selectedBeneficiary!.phone ?? 'Tidak tersedia',
                  Icons.phone,
                ),

                const SizedBox(height: 12),

                // Address Info
                Container(
                  padding: const EdgeInsets.all(12),
                  decoration: BoxDecoration(
                    color: AppTheme.backgroundColor,
                    borderRadius: BorderRadius.circular(8),
                  ),
                  child: Column(
                    crossAxisAlignment: CrossAxisAlignment.start,
                    children: [
                      const Row(
                        children: [
                          Icon(
                            Icons.location_on,
                            color: AppTheme.primaryColor,
                            size: 16,
                          ),
                          SizedBox(width: 6),
                          Text(
                            'Alamat Lengkap',
                            style: TextStyle(
                              fontSize: 12,
                              fontWeight: FontWeight.w600,
                              color: AppTheme.primaryColor,
                            ),
                          ),
                        ],
                      ),
                      const SizedBox(height: 6),
                      Text(
                        widget.selectedBeneficiary!.fullAddress,
                        style: const TextStyle(
                          fontSize: 14,
                          color: AppTheme.textPrimaryColor,
                        ),
                      ),
                    ],
                  ),
                ),
              ],
            ),
          ),
        );
      },
    );
  }

  Widget _buildInfoRow(String label, String value, IconData icon) {
    return Padding(
      padding: const EdgeInsets.only(bottom: 8),
      child: Row(
        children: [
          Icon(
            icon,
            color: AppTheme.textSecondaryColor,
            size: 16,
          ),
          const SizedBox(width: 8),
          Text(
            '$label: ',
            style: const TextStyle(
              fontSize: 13,
              color: AppTheme.textSecondaryColor,
              fontWeight: FontWeight.w500,
            ),
          ),
          Expanded(
            child: Text(
              value,
              style: const TextStyle(
                fontSize: 13,
                color: AppTheme.textPrimaryColor,
                fontWeight: FontWeight.w500,
              ),
            ),
          ),
        ],
      ),
    );
  }
}
