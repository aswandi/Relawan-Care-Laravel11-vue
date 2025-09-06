class Beneficiary {
  final int id;
  final String nik;
  final String name;
  final String? phone;
  final String address;
  final String? kabupatenName;
  final String? kecamatanName;
  final String? desaName;
  final DateTime? createdAt;

  Beneficiary({
    required this.id,
    required this.nik,
    required this.name,
    this.phone,
    required this.address,
    this.kabupatenName,
    this.kecamatanName,
    this.desaName,
    this.createdAt,
  });

  factory Beneficiary.fromJson(Map<String, dynamic> json) {
    return Beneficiary(
      id: json['id'],
      nik: json['nik'],
      name: json['name'],
      phone: json['phone'],
      address: json['address'],
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
      'nik': nik,
      'name': name,
      'phone': phone,
      'address': address,
      'kabupaten_name': kabupatenName,
      'kecamatan_name': kecamatanName,
      'desa_name': desaName,
      'created_at': createdAt?.toIso8601String(),
    };
  }

  String get fullAddress {
    List<String> parts = [address];
    if (desaName != null) parts.add(desaName!);
    if (kecamatanName != null) parts.add(kecamatanName!);
    if (kabupatenName != null) parts.add(kabupatenName!);
    return parts.join(', ');
  }
}