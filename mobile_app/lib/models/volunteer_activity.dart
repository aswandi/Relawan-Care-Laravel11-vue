import 'beneficiary.dart';

class VolunteerActivity {
  final int id;
  final int volunteerId;
  final int beneficiaryId;
  final int? aidSessionId;
  final DateTime visitDate;
  final double? latitude;
  final double? longitude;
  final String? notes;
  final String status;
  final Beneficiary? beneficiary;
  final List<ActivityAid> aids;
  final List<ActivityPhoto> photos;
  final DateTime? createdAt;

  VolunteerActivity({
    required this.id,
    required this.volunteerId,
    required this.beneficiaryId,
    this.aidSessionId,
    required this.visitDate,
    this.latitude,
    this.longitude,
    this.notes,
    required this.status,
    this.beneficiary,
    this.aids = const [],
    this.photos = const [],
    this.createdAt,
  });

  factory VolunteerActivity.fromJson(Map<String, dynamic> json) {
    return VolunteerActivity(
      id: json['id'],
      volunteerId: json['volunteer_id'],
      beneficiaryId: json['beneficiary_id'],
      aidSessionId: json['aid_session_id'],
      visitDate: DateTime.parse(json['visit_date']),
      latitude: json['latitude']?.toDouble(),
      longitude: json['longitude']?.toDouble(),
      notes: json['notes'],
      status: json['status'] ?? 'completed',
      beneficiary: json['beneficiary'] != null 
          ? Beneficiary.fromJson(json['beneficiary']) 
          : null,
      aids: (json['aids'] as List?)
          ?.map((aid) => ActivityAid.fromJson(aid))
          .toList() ?? [],
      photos: (json['photos'] as List?)
          ?.map((photo) => ActivityPhoto.fromJson(photo))
          .toList() ?? [],
      createdAt: json['created_at'] != null 
          ? DateTime.parse(json['created_at']) 
          : null,
    );
  }

  Map<String, dynamic> toJson() {
    return {
      'id': id,
      'volunteer_id': volunteerId,
      'beneficiary_id': beneficiaryId,
      'aid_session_id': aidSessionId,
      'visit_date': visitDate.toIso8601String(),
      'latitude': latitude,
      'longitude': longitude,
      'notes': notes,
      'status': status,
      'beneficiary': beneficiary?.toJson(),
      'aids': aids.map((aid) => aid.toJson()).toList(),
      'photos': photos.map((photo) => photo.toJson()).toList(),
      'created_at': createdAt?.toIso8601String(),
    };
  }

  String get formattedDate {
    return '${visitDate.day}/${visitDate.month}/${visitDate.year}';
  }

  String get formattedTime {
    return '${visitDate.hour.toString().padLeft(2, '0')}:${visitDate.minute.toString().padLeft(2, '0')}';
  }

  String get statusDisplayName {
    switch (status) {
      case 'pending':
        return 'Menunggu';
      case 'completed':
        return 'Selesai';
      case 'cancelled':
        return 'Dibatalkan';
      default:
        return 'Tidak Diketahui';
    }
  }

  bool get hasLocation => latitude != null && longitude != null;

  int get totalAids => aids.fold(0, (sum, aid) => sum + aid.quantity);
}

class ActivityAid {
  final int id;
  final int volunteerActivityId;
  final int aidTypeId;
  final int quantity;
  final double? nominalAmount;
  final String? aidTypeName;
  final String? aidTypeUnit;

  ActivityAid({
    required this.id,
    required this.volunteerActivityId,
    required this.aidTypeId,
    required this.quantity,
    this.nominalAmount,
    this.aidTypeName,
    this.aidTypeUnit,
  });

  factory ActivityAid.fromJson(Map<String, dynamic> json) {
    return ActivityAid(
      id: json['id'],
      volunteerActivityId: json['volunteer_activity_id'],
      aidTypeId: json['aid_type_id'],
      quantity: json['quantity'],
      nominalAmount: json['nominal_amount']?.toDouble(),
      aidTypeName: json['aid_type']?['name'],
      aidTypeUnit: json['aid_type']?['unit'],
    );
  }

  Map<String, dynamic> toJson() {
    return {
      'id': id,
      'volunteer_activity_id': volunteerActivityId,
      'aid_type_id': aidTypeId,
      'quantity': quantity,
      'nominal_amount': nominalAmount,
      'aid_type_name': aidTypeName,
      'aid_type_unit': aidTypeUnit,
    };
  }

  String get displayValue {
    if (nominalAmount != null && nominalAmount! > 0) {
      return 'Rp ${nominalAmount!.toStringAsFixed(0).replaceAllMapped(
        RegExp(r'(\d{1,3})(?=(\d{3})+(?!\d))'),
        (Match m) => '${m[1]}.',
      )}';
    }
    return '$quantity ${aidTypeUnit ?? 'unit'}';
  }
}

class ActivityPhoto {
  final int id;
  final int volunteerActivityId;
  final String photoPath;
  final String? description;
  final DateTime? createdAt;

  ActivityPhoto({
    required this.id,
    required this.volunteerActivityId,
    required this.photoPath,
    this.description,
    this.createdAt,
  });

  factory ActivityPhoto.fromJson(Map<String, dynamic> json) {
    return ActivityPhoto(
      id: json['id'],
      volunteerActivityId: json['volunteer_activity_id'],
      photoPath: json['photo_path'],
      description: json['description'],
      createdAt: json['created_at'] != null 
          ? DateTime.parse(json['created_at']) 
          : null,
    );
  }

  Map<String, dynamic> toJson() {
    return {
      'id': id,
      'volunteer_activity_id': volunteerActivityId,
      'photo_path': photoPath,
      'description': description,
      'created_at': createdAt?.toIso8601String(),
    };
  }

  String get fullPhotoUrl {
    // Assuming photos are stored in storage/app/public/photos
    return 'http://localhost:8001/storage/photos/$photoPath';
  }
}