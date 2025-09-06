import 'dart:convert';
import 'dart:io';
import 'package:http/http.dart' as http;
import '../models/volunteer_activity.dart';
import '../models/beneficiary.dart';

class ActivityService {
  static const String baseUrl = 'http://localhost:8001/api';

  Future<List<VolunteerActivity>> getVolunteerActivities(
    int volunteerId, {
    int? limit,
  }) async {
    try {
      String url = '$baseUrl/volunteer/$volunteerId/activities';
      if (limit != null) {
        url += '?limit=$limit';
      }

      final response = await http.get(
        Uri.parse(url),
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
        },
      );

      if (response.statusCode == 200) {
        final data = jsonDecode(response.body);
        if (data['success']) {
          List<dynamic> activitiesJson = data['activities'];
          return activitiesJson
              .map((json) => VolunteerActivity.fromJson(json))
              .toList();
        } else {
          throw Exception(data['message'] ?? 'Failed to load activities');
        }
      } else {
        throw Exception('Server error: ${response.statusCode}');
      }
    } catch (e) {
      throw Exception('Failed to load activities: ${e.toString()}');
    }
  }

  Future<Beneficiary?> searchBeneficiaryByNik(String nik) async {
    try {
      final response = await http.get(
        Uri.parse('$baseUrl/beneficiary/search?nik=$nik'),
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
        },
      );

      if (response.statusCode == 200) {
        final data = jsonDecode(response.body);
        if (data['success'] && data['beneficiary'] != null) {
          return Beneficiary.fromJson(data['beneficiary']);
        }
        return null;
      } else if (response.statusCode == 404) {
        return null;
      } else {
        throw Exception('Server error: ${response.statusCode}');
      }
    } catch (e) {
      throw Exception('Failed to search beneficiary: ${e.toString()}');
    }
  }

  Future<bool> createActivity({
    required int volunteerId,
    required int beneficiaryId,
    required DateTime visitDate,
    required double latitude,
    required double longitude,
    String? notes,
    required List<Map<String, dynamic>> aids,
    required List<File> photos,
  }) async {
    try {
      var request = http.MultipartRequest(
        'POST',
        Uri.parse('$baseUrl/volunteer/activity'),
      );

      // Add form fields
      request.fields['volunteer_id'] = volunteerId.toString();
      request.fields['beneficiary_id'] = beneficiaryId.toString();
      request.fields['visit_date'] = visitDate.toIso8601String();
      request.fields['latitude'] = latitude.toString();
      request.fields['longitude'] = longitude.toString();
      if (notes != null) {
        request.fields['notes'] = notes;
      }
      request.fields['aids'] = jsonEncode(aids);

      // Add photo files
      for (int i = 0; i < photos.length; i++) {
        var file = await http.MultipartFile.fromPath(
          'photos[]',
          photos[i].path,
        );
        request.files.add(file);
      }

      // Add headers
      request.headers.addAll({
        'Accept': 'application/json',
      });

      final streamedResponse = await request.send();
      final response = await http.Response.fromStream(streamedResponse);

      if (response.statusCode == 201 || response.statusCode == 200) {
        final data = jsonDecode(response.body);
        return data['success'] ?? false;
      } else {
        print('Server error: ${response.statusCode}');
        print('Response body: ${response.body}');
        return false;
      }
    } catch (e) {
      print('Error creating activity: ${e.toString()}');
      return false;
    }
  }

  Future<List<Map<String, dynamic>>> getAidTypes() async {
    try {
      final response = await http.get(
        Uri.parse('$baseUrl/aid-types'),
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
        },
      );

      if (response.statusCode == 200) {
        final data = jsonDecode(response.body);
        if (data['success']) {
          return List<Map<String, dynamic>>.from(data['aid_types']);
        } else {
          throw Exception(data['message'] ?? 'Failed to load aid types');
        }
      } else {
        throw Exception('Server error: ${response.statusCode}');
      }
    } catch (e) {
      throw Exception('Failed to load aid types: ${e.toString()}');
    }
  }

  Future<bool> updateActivity(
    int activityId, {
    DateTime? visitDate,
    double? latitude,
    double? longitude,
    String? notes,
    List<Map<String, dynamic>>? aids,
    List<File>? newPhotos,
  }) async {
    try {
      var request = http.MultipartRequest(
        'PUT',
        Uri.parse('$baseUrl/volunteer/activity/$activityId'),
      );

      // Add form fields
      if (visitDate != null) {
        request.fields['visit_date'] = visitDate.toIso8601String();
      }
      if (latitude != null) {
        request.fields['latitude'] = latitude.toString();
      }
      if (longitude != null) {
        request.fields['longitude'] = longitude.toString();
      }
      if (notes != null) {
        request.fields['notes'] = notes;
      }
      if (aids != null) {
        request.fields['aids'] = jsonEncode(aids);
      }

      // Add new photo files if provided
      if (newPhotos != null) {
        for (int i = 0; i < newPhotos.length; i++) {
          var file = await http.MultipartFile.fromPath(
            'photos[]',
            newPhotos[i].path,
          );
          request.files.add(file);
        }
      }

      // Add headers
      request.headers.addAll({
        'Accept': 'application/json',
      });

      final streamedResponse = await request.send();
      final response = await http.Response.fromStream(streamedResponse);

      if (response.statusCode == 200) {
        final data = jsonDecode(response.body);
        return data['success'] ?? false;
      } else {
        return false;
      }
    } catch (e) {
      return false;
    }
  }

  Future<bool> deleteActivity(int activityId) async {
    try {
      final response = await http.delete(
        Uri.parse('$baseUrl/volunteer/activity/$activityId'),
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
        },
      );

      if (response.statusCode == 200) {
        final data = jsonDecode(response.body);
        return data['success'] ?? false;
      } else {
        return false;
      }
    } catch (e) {
      return false;
    }
  }
}