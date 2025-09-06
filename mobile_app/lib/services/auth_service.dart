import 'package:flutter/material.dart';
import 'package:http/http.dart' as http;
import 'package:shared_preferences/shared_preferences.dart';
import 'dart:convert';
import '../models/volunteer.dart';

class AuthService extends ChangeNotifier {
  static const String baseUrl = 'http://localhost:8001/api';
  Volunteer? _currentVolunteer;
  bool _isLoading = false;
  String? _error;

  Volunteer? get currentVolunteer => _currentVolunteer;
  bool get isLoading => _isLoading;
  String? get error => _error;
  bool get isLoggedIn => _currentVolunteer != null;

  Future<bool> login(String phone, String password) async {
    _setLoading(true);
    _error = null;
    
    try {
      final response = await http.post(
        Uri.parse('$baseUrl/volunteer/login'),
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
        },
        body: jsonEncode({
          'phone': phone,
          'password': password,
        }),
      );

      if (response.statusCode == 200) {
        final data = jsonDecode(response.body);
        
        if (data['success']) {
          _currentVolunteer = Volunteer.fromJson(data['volunteer']);
          
          // Save to SharedPreferences
          SharedPreferences prefs = await SharedPreferences.getInstance();
          await prefs.setBool('isLoggedIn', true);
          await prefs.setInt('volunteerId', _currentVolunteer!.id);
          await prefs.setString('volunteerData', jsonEncode(_currentVolunteer!.toJson()));
          
          _setLoading(false);
          return true;
        } else {
          _error = data['message'] ?? 'Login gagal';
          _setLoading(false);
          return false;
        }
      } else {
        _error = 'Server error: ${response.statusCode}';
        _setLoading(false);
        return false;
      }
    } catch (e) {
      _error = 'Koneksi error: ${e.toString()}';
      _setLoading(false);
      return false;
    }
  }

  Future<void> loadStoredUser() async {
    try {
      SharedPreferences prefs = await SharedPreferences.getInstance();
      bool isLoggedIn = prefs.getBool('isLoggedIn') ?? false;
      
      if (isLoggedIn) {
        String? volunteerData = prefs.getString('volunteerData');
        if (volunteerData != null) {
          _currentVolunteer = Volunteer.fromJson(jsonDecode(volunteerData));
          notifyListeners();
        }
      }
    } catch (e) {
      print('Error loading stored user: $e');
    }
  }

  Future<void> logout() async {
    try {
      SharedPreferences prefs = await SharedPreferences.getInstance();
      await prefs.clear();
      
      _currentVolunteer = null;
      _error = null;
      notifyListeners();
    } catch (e) {
      print('Error during logout: $e');
    }
  }

  void _setLoading(bool value) {
    _isLoading = value;
    notifyListeners();
  }

  void clearError() {
    _error = null;
    notifyListeners();
  }
}