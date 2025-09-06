class Volunteer {
  final int id;
  final String name;
  final String phone;
  final String? email;
  final bool isActive;
  final String? kabupatenName;
  final String? kecamatanName;
  final String? desaName;
  final DateTime? createdAt;

  Volunteer({
    required this.id,
    required this.name,
    required this.phone,
    this.email,
    required this.isActive,
    this.kabupatenName,
    this.kecamatanName,
    this.desaName,
    this.createdAt,
  });

  factory Volunteer.fromJson(Map<String, dynamic> json) {
    return Volunteer(
      id: json['id'],
      name: json['name'],
      phone: json['phone'],
      email: json['email'],
      isActive: json['is_active'] ?? true,
      kabupatenName: json['kabupaten']?['kab_nama'],
      kecamatanName: json['kecamatan']?['kec_nama'],
      desaName: json['desa']?['kel_nama'],
      createdAt: json['created_at'] != null 
          ? DateTime.parse(json['created_at']) 
          : null,
    );
  }

  Map<String, dynamic> toJson() {
    return {
      'id': id,
      'name': name,
      'phone': phone,
      'email': email,
      'is_active': isActive,
      'kabupaten_name': kabupatenName,
      'kecamatan_name': kecamatanName,
      'desa_name': desaName,
      'created_at': createdAt?.toIso8601String(),
    };
  }

  String get fullAddress {
    List<String> parts = [];
    if (desaName != null) parts.add(desaName!);
    if (kecamatanName != null) parts.add(kecamatanName!);
    if (kabupatenName != null) parts.add(kabupatenName!);
    return parts.join(', ');
  }
}