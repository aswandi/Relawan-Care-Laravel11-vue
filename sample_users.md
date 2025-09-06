# Sample Users for RelawanCare System

This document contains all sample user accounts created in the system for testing and development purposes.

## 🔐 **Login Credentials**

All users can login to the system using their email and password below:

### **Administrative Accounts**
| Name | Email | Password | Role |
|------|--------|----------|------|
| Administrator | admin@relawancare.com | password | Main Admin |
| Test User | test@relawancare.com | password | Test Account |
| Demo Account | demo@relawancare.com | demo123 | Demo Account |

### **Staff Accounts**
| Name | Email | Password | Description |
|------|--------|----------|-------------|
| Dr. Sari Wijaya | sari.wijaya@relawancare.com | password123 | Senior Staff |
| Budi Santoso | budi.santoso@relawancare.com | password123 | Program Coordinator |
| Indah Pertiwi | indah.pertiwi@relawancare.com | password123 | Data Analyst |
| Ahmad Hidayat | ahmad.hidayat@relawancare.com | password123 | Field Supervisor |
| Rina Marlina | rina.marlina@relawancare.com | password123 | Social Worker |
| Dedi Kurniawan | dedi.kurniawan@relawancare.com | password123 | Logistics Manager |
| Maya Sari | maya.sari@relawancare.com | password123 | Communications Officer |
| Eko Prasetyo | eko.prasetyo@relawancare.com | password123 | IT Support |
| Dewi Lestari | dewi.lestari@relawancare.com | password123 | Finance Officer |
| Handi Setiawan | handi.setiawan@relawancare.com | password123 | Operations Manager |
| Lina Fitriani | lina.fitriani@relawancare.com | password123 | Community Liaison |
| Andi Nugroho | andi.nugroho@relawancare.com | password123 | Training Coordinator |
| Sinta Dewi | sinta.dewi@relawancare.com | password123 | Volunteer Coordinator |

## 📊 **Statistics**
- **Total Users**: 16
- **Admin Accounts**: 3
- **Staff Accounts**: 13
- **All accounts verified**: ✅

## 🚀 **How to Use**

1. **Access the system**: http://localhost:8001
2. **Login Page**: Use any email and password combination from the table above
3. **Main Admin Access**: Use `admin@relawancare.com` / `password` for full administrative access
4. **Quick Test**: Use `test@relawancare.com` / `password` for quick testing
5. **Demo Mode**: Use `demo@relawancare.com` / `demo123` for demonstrations

## 🔄 **Re-seeding Users**

To recreate all sample users, run:
```bash
php artisan db:seed --class=UserSeeder
```

To seed all data including users:
```bash
php artisan db:seed
```

## 🔒 **Security Notes**

- All passwords are hashed using Laravel's secure Hash facade
- All accounts have verified email addresses
- These are sample accounts for development/testing only
- Change passwords for production use
- The system uses Laravel's built-in authentication

## 📝 **Account Features**

Each user account includes:
- Unique email address
- Hashed password
- Email verification timestamp
- Full access to RelawanCare system features
- Access to all master data management
- Ability to manage volunteers, beneficiaries, and groups