import 'package:flutter/material.dart';
import '../services/activity_service.dart';
import '../utils/app_theme.dart';

class AidSelectorWidget extends StatefulWidget {
  final List<Map<String, dynamic>> selectedAids;
  final Function(List<Map<String, dynamic>>) onAidsChanged;

  const AidSelectorWidget({
    Key? key,
    required this.selectedAids,
    required this.onAidsChanged,
  }) : super(key: key);

  @override
  _AidSelectorWidgetState createState() => _AidSelectorWidgetState();
}

class _AidSelectorWidgetState extends State<AidSelectorWidget>
    with TickerProviderStateMixin {
  final _activityService = ActivityService();

  List<Map<String, dynamic>> _availableAidTypes = [];
  bool _isLoading = true;
  String? _error;

  late AnimationController _animationController;
  late Animation<double> _fadeAnimation;

  @override
  void initState() {
    super.initState();

    _animationController = AnimationController(
      duration: const Duration(milliseconds: 500),
      vsync: this,
    );

    _fadeAnimation = Tween<double>(
      begin: 0.0,
      end: 1.0,
    ).animate(CurvedAnimation(
      parent: _animationController,
      curve: Curves.easeInOut,
    ));

    _loadAidTypes();
  }

  @override
  void dispose() {
    _animationController.dispose();
    super.dispose();
  }

  Future<void> _loadAidTypes() async {
    try {
      final aidTypes = await _activityService.getAidTypes();
      setState(() {
        _availableAidTypes = aidTypes;
        _isLoading = false;
      });
      _animationController.forward();
    } catch (e) {
      setState(() {
        _error = e.toString();
        _isLoading = false;
      });
    }
  }

  void _showAddAidDialog() {
    showDialog(
      context: context,
      builder: (context) => _AddAidDialog(
        availableAidTypes: _availableAidTypes,
        onAidAdded: (aid) {
          List<Map<String, dynamic>> updatedAids =
              List.from(widget.selectedAids);
          updatedAids.add(aid);
          widget.onAidsChanged(updatedAids);
        },
      ),
    );
  }

  void _editAid(int index) {
    showDialog(
      context: context,
      builder: (context) => _AddAidDialog(
        availableAidTypes: _availableAidTypes,
        initialAid: widget.selectedAids[index],
        onAidAdded: (aid) {
          List<Map<String, dynamic>> updatedAids =
              List.from(widget.selectedAids);
          updatedAids[index] = aid;
          widget.onAidsChanged(updatedAids);
        },
      ),
    );
  }

  void _removeAid(int index) {
    List<Map<String, dynamic>> updatedAids = List.from(widget.selectedAids);
    updatedAids.removeAt(index);
    widget.onAidsChanged(updatedAids);
  }

  @override
  Widget build(BuildContext context) {
    return Container(
      decoration: AppTheme.cardDecoration(),
      padding: const EdgeInsets.all(16),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          const Text(
            'Bantuan yang Diberikan',
            style: TextStyle(
              fontSize: 16,
              fontWeight: FontWeight.w600,
              color: AppTheme.textPrimaryColor,
            ),
          ),
          const SizedBox(height: 12),
          const Text(
            'Pilih jenis bantuan dan jumlah yang diberikan kepada penerima',
            style: TextStyle(
              fontSize: 12,
              color: AppTheme.textSecondaryColor,
              fontStyle: FontStyle.italic,
            ),
          ),
          const SizedBox(height: 16),
          if (_isLoading)
            const Center(
              child: Padding(
                padding: EdgeInsets.all(20),
                child: CircularProgressIndicator(),
              ),
            )
          else if (_error != null)
            Container(
              padding: const EdgeInsets.all(12),
              decoration: BoxDecoration(
                color: AppTheme.dangerColor.withOpacity(0.1),
                borderRadius: BorderRadius.circular(8),
                border:
                    Border.all(color: AppTheme.dangerColor.withOpacity(0.3)),
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
            )
          else
            AnimatedBuilder(
              animation: _animationController,
              builder: (context, child) {
                return FadeTransition(
                  opacity: _fadeAnimation,
                  child: Column(
                    children: [
                      // Selected Aids List
                      if (widget.selectedAids.isNotEmpty) ...[
                        ListView.separated(
                          shrinkWrap: true,
                          physics: const NeverScrollableScrollPhysics(),
                          itemCount: widget.selectedAids.length,
                          separatorBuilder: (context, index) =>
                              const SizedBox(height: 8),
                          itemBuilder: (context, index) {
                            return _buildAidCard(
                                widget.selectedAids[index], index);
                          },
                        ),
                        const SizedBox(height: 16),
                      ],

                      // Add Aid Button
                      SizedBox(
                        width: double.infinity,
                        height: 48,
                        child: OutlinedButton.icon(
                          onPressed: _showAddAidDialog,
                          icon: const Icon(Icons.add),
                          label: Text(
                            widget.selectedAids.isEmpty
                                ? 'Tambah Bantuan Pertama'
                                : 'Tambah Bantuan Lagi',
                          ),
                          style: OutlinedButton.styleFrom(
                            foregroundColor: AppTheme.accentColor,
                            side: const BorderSide(color: AppTheme.accentColor),
                            shape: RoundedRectangleBorder(
                              borderRadius: BorderRadius.circular(12),
                            ),
                          ),
                        ),
                      ),
                    ],
                  ),
                );
              },
            ),
        ],
      ),
    );
  }

  Widget _buildAidCard(Map<String, dynamic> aid, int index) {
    final aidType = _availableAidTypes.firstWhere(
      (type) => type['id'] == aid['aid_type_id'],
      orElse: () => {'name': 'Unknown', 'unit': 'unit', 'type': 'item'},
    );

    return Container(
      padding: const EdgeInsets.all(12),
      decoration: BoxDecoration(
        color: AppTheme.backgroundColor,
        borderRadius: BorderRadius.circular(8),
        border: Border.all(color: AppTheme.borderColor),
      ),
      child: Row(
        children: [
          Container(
            padding: const EdgeInsets.all(8),
            decoration: BoxDecoration(
              color: AppTheme.accentColor.withOpacity(0.1),
              borderRadius: BorderRadius.circular(6),
            ),
            child: Icon(
              aidType['type'] == 'cash'
                  ? Icons.monetization_on
                  : Icons.card_giftcard,
              color: AppTheme.accentColor,
              size: 20,
            ),
          ),
          const SizedBox(width: 12),
          Expanded(
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                Text(
                  aidType['name'],
                  style: const TextStyle(
                    fontSize: 14,
                    fontWeight: FontWeight.w600,
                    color: AppTheme.textPrimaryColor,
                  ),
                ),
                Text(
                  _formatAidValue(aid, aidType),
                  style: const TextStyle(
                    fontSize: 12,
                    color: AppTheme.textSecondaryColor,
                  ),
                ),
              ],
            ),
          ),
          Row(
            mainAxisSize: MainAxisSize.min,
            children: [
              IconButton(
                icon: const Icon(Icons.edit, size: 20),
                color: AppTheme.primaryColor,
                onPressed: () => _editAid(index),
                constraints: BoxConstraints.tight(const Size(32, 32)),
                padding: EdgeInsets.zero,
              ),
              IconButton(
                icon: const Icon(Icons.delete, size: 20),
                color: AppTheme.dangerColor,
                onPressed: () => _removeAid(index),
                constraints: BoxConstraints.tight(const Size(32, 32)),
                padding: EdgeInsets.zero,
              ),
            ],
          ),
        ],
      ),
    );
  }

  String _formatAidValue(
      Map<String, dynamic> aid, Map<String, dynamic> aidType) {
    if (aidType['type'] == 'cash' && aid['nominal_amount'] != null) {
      return 'Rp ${aid['nominal_amount'].toString().replaceAllMapped(
            RegExp(r'(\d{1,3})(?=(\d{3})+(?!\d))'),
            (Match m) => '${m[1]}.',
          )}';
    }
    return '${aid['quantity']} ${aidType['unit'] ?? 'unit'}';
  }
}

class _AddAidDialog extends StatefulWidget {
  final List<Map<String, dynamic>> availableAidTypes;
  final Map<String, dynamic>? initialAid;
  final Function(Map<String, dynamic>) onAidAdded;

  const _AddAidDialog({
    required this.availableAidTypes,
    this.initialAid,
    required this.onAidAdded,
  });

  @override
  _AddAidDialogState createState() => _AddAidDialogState();
}

class _AddAidDialogState extends State<_AddAidDialog> {
  final _formKey = GlobalKey<FormState>();
  final _quantityController = TextEditingController();
  final _nominalController = TextEditingController();

  Map<String, dynamic>? _selectedAidType;

  @override
  void initState() {
    super.initState();

    if (widget.initialAid != null) {
      _selectedAidType = widget.availableAidTypes.firstWhere(
        (type) => type['id'] == widget.initialAid!['aid_type_id'],
        orElse: () => widget.availableAidTypes.first,
      );
      _quantityController.text = widget.initialAid!['quantity'].toString();
      if (widget.initialAid!['nominal_amount'] != null) {
        _nominalController.text =
            widget.initialAid!['nominal_amount'].toString();
      }
    }
  }

  @override
  void dispose() {
    _quantityController.dispose();
    _nominalController.dispose();
    super.dispose();
  }

  void _submitAid() {
    if (!_formKey.currentState!.validate()) return;
    if (_selectedAidType == null) return;

    final aid = {
      'aid_type_id': _selectedAidType!['id'],
      'quantity': int.parse(_quantityController.text),
      'nominal_amount': _selectedAidType!['type'] == 'cash' &&
              _nominalController.text.isNotEmpty
          ? double.parse(_nominalController.text)
          : null,
    };

    widget.onAidAdded(aid);
    Navigator.pop(context);
  }

  @override
  Widget build(BuildContext context) {
    return AlertDialog(
      title:
          Text(widget.initialAid != null ? 'Edit Bantuan' : 'Tambah Bantuan'),
      content: SingleChildScrollView(
        child: Form(
          key: _formKey,
          child: Column(
            mainAxisSize: MainAxisSize.min,
            children: [
              // Aid Type Dropdown
              DropdownButtonFormField<Map<String, dynamic>>(
                value: _selectedAidType,
                decoration: const InputDecoration(
                  labelText: 'Jenis Bantuan',
                  prefixIcon: Icon(Icons.card_giftcard),
                ),
                items: widget.availableAidTypes.map((aidType) {
                  return DropdownMenuItem(
                    value: aidType,
                    child: Text(aidType['name']),
                  );
                }).toList(),
                onChanged: (value) {
                  setState(() {
                    _selectedAidType = value;
                    _nominalController.clear();
                  });
                },
                validator: (value) {
                  if (value == null) return 'Pilih jenis bantuan';
                  return null;
                },
              ),

              const SizedBox(height: 16),

              // Quantity Field
              TextFormField(
                controller: _quantityController,
                keyboardType: TextInputType.number,
                decoration: InputDecoration(
                  labelText: 'Jumlah',
                  suffixText: _selectedAidType?['unit'] ?? 'unit',
                  prefixIcon: const Icon(Icons.pin),
                ),
                validator: (value) {
                  if (value == null || value.isEmpty) {
                    return 'Jumlah wajib diisi';
                  }
                  if (int.tryParse(value) == null || int.parse(value) <= 0) {
                    return 'Jumlah harus berupa angka positif';
                  }
                  return null;
                },
              ),

              // Nominal Amount Field (for cash aids)
              if (_selectedAidType?['type'] == 'cash') ...[
                const SizedBox(height: 16),
                TextFormField(
                  controller: _nominalController,
                  keyboardType: TextInputType.number,
                  decoration: const InputDecoration(
                    labelText: 'Nominal (Rp)',
                    prefixIcon: Icon(Icons.monetization_on),
                  ),
                  validator: (value) {
                    if (_selectedAidType?['type'] == 'cash') {
                      if (value == null || value.isEmpty) {
                        return 'Nominal wajib diisi';
                      }
                      if (double.tryParse(value) == null ||
                          double.parse(value) <= 0) {
                        return 'Nominal harus berupa angka positif';
                      }
                    }
                    return null;
                  },
                ),
              ],
            ],
          ),
        ),
      ),
      actions: [
        TextButton(
          onPressed: () => Navigator.pop(context),
          child: const Text('Batal'),
        ),
        ElevatedButton(
          onPressed: _submitAid,
          child: Text(widget.initialAid != null ? 'Update' : 'Tambah'),
        ),
      ],
    );
  }
}
