# 🏢 RAVI Modular Cabinet - Booking System

> A personal project for learning web development - An appointment booking system with Firebase integration, admin dashboard, and animated website

> **Note**: This is a personal/educational project created for learning purposes. It may contain areas that need improvement and is not intended for production use without further development and security hardening.

---

## 📋 Table of Contents

- [Overview](#overview)
- [Features](#features)
- [System Architecture](#system-architecture)
- [Quick Start](#quick-start)
- [Installation](#installation)
- [Configuration](#configuration)
- [Usage Guide](#usage-guide)
- [Admin Dashboard](#admin-dashboard)
- [Website Features](#website-features)
- [Database Structure](#database-structure)
- [Security](#security)
- [Troubleshooting](#troubleshooting)
- [Contributing](#contributing)
- [License](#license)

## 🎯 Overview

RAVI Modular Cabinet Booking System is a personal web development project created to learn and practice modern web technologies. This project demonstrates the implementation of a booking system with Firebase integration, responsive design, and interactive features.

### Project Purpose

This project was built as a learning exercise to:
- Practice PHP backend development
- Learn Firebase Realtime Database integration
- Implement responsive web design
- Create interactive UI/UX with JavaScript
- Understand session-based authentication
- Build a complete CRUD application

### What's Includedt Booking System is a complete web application for managing cabinet design and installation appointments. It features a modern customer-facing website with booking capabilities and a powerful admin dashboard for managing requests.

### What's Included

- ✅ **5-Page Business Website** (Home, Gallery, About, Contact, Booking)
- ✅ **Customer Booking System** with real-time validation
- ✅ **Admin Dashboard** with advanced management features
- ✅ **Firebase Realtime Database** integration
- ✅ **Responsive Design** (mobile, tablet, desktop)
- ✅ **Modern Animations** and interactive elements
- ✅ **Search & Filter** functionality
- ✅ **Bulk Operations** support
- ✅ **Print-Friendly** views

---

## ✨ Features

### Customer Features

#### Website Pages
- **Home Page** - Hero section, features, services showcase, statistics
- **Gallery** - Image lightbox, search, filter by category
- **About Us** - Company info, leadership team, installation team
- **Contact** - Contact form, social media links, quick links
- **Booking Form** - Multi-field appointment request system

#### Interactive Elements
- 🎨 Smooth scroll animations
- 🖼️ Image lightbox with keyboard navigation
- 📊 Animated statistics counters
- 🔍 Real-time search functionality
- 🎯 Hover effects and transitions
- 📱 Fully responsive design
- 🌙 Theme toggle (light/dark mode)
- ⬆️ Back to top button

### Admin Features

#### Dashboard Capabilities
- 📊 **Statistics Dashboard** - Total, pending, completed counts
- 🔍 **Real-Time Search** - Search across all fields
- 🏷️ **Status Filtering** - All, pending, completed views
- 👁️ **View Details Modal** - Full appointment information
- ✅ **Mark Complete** - Update appointment status
- 🗑️ **Delete** - Remove single appointments
- ☑️ **Bulk Selection** - Select multiple appointments
- 🗑️ **Bulk Delete** - Delete multiple at once
- 🖨️ **Print View** - Print-friendly format
- 📱 **Mobile Responsive** - Works on all devices

#### Modern UI/UX
- Gradient backgrounds and smooth animations
- Card-based layout with hover effects
- Custom scrollbars with gradient colors
- Professional color scheme
- Intuitive navigation
- Loading states and feedback

---

## 🏗️ System Architecture

```
┌─────────────────────────────────────────────────────────────┐
│                    CUSTOMER INTERFACE                       │
│  Home → Gallery → About → Contact → Booking Form           │
└────────────────────────┬────────────────────────────────────┘
                         │
                         ↓ (POST)
┌─────────────────────────────────────────────────────────────┐
│                   FORM SUBMISSION                           │
│              submit_form.php (Validation)                   │
└────────────────────────┬────────────────────────────────────┘
                         │
                         ↓ (cURL)
┌─────────────────────────────────────────────────────────────┐
│                  FIREBASE DATABASE                          │
│     https://ravi-forms-default-rtdb.firebaseio.com/        │
│                  appointments/                              │
└────────────────────────┬────────────────────────────────────┘
                         │
                         ↓ (Retrieve)
┌─────────────────────────────────────────────────────────────┐
│                   ADMIN INTERFACE                           │
│         Login → Dashboard → Manage Appointments             │
└─────────────────────────────────────────────────────────────┘
```

### Technology Stack

**Frontend:**
- HTML5, CSS3 (Custom, no framework)
- Vanilla JavaScript (ES6+)
- Font Awesome 6.5.1
- Google Fonts (Raleway, Poppins)

**Backend:**
- PHP 7.4+
- Firebase Realtime Database
- Session-based authentication

**Server:**
- Apache (XAMPP)
- cURL for Firebase API calls

---

## 🚀 Quick Start

### Prerequisites

- XAMPP (or similar PHP server)
- Web browser (Chrome, Firefox, Safari, Edge)
- Firebase account (free tier works)
- Internet connection

### 3-Step Setup

1. **Start XAMPP**
   ```bash
   Open XAMPP Control Panel
   Start Apache
   ```

2. **Configure Firebase**
   - Update `ravi(htdocs)FIREBASE-PHP/config.php` with your database URL
   - Set Firebase security rules (see Configuration section)

3. **Test the System**
   ```
   Open: http://localhost/RAVI%20WEBSITE/test_database.php
   Click: "Create Test Appointment"
   ```

### Access Points

| Page | URL |
|------|-----|
| Website Home | `http://localhost/RAVI%20WEBSITE/` |
| Booking Form | `http://localhost/RAVI%20WEBSITE/PHP/forms.php` |
| Admin Login | `http://localhost/RAVI%20WEBSITE/PHP/adminlogin.php` |
| Test Database | `http://localhost/RAVI%20WEBSITE/test_database.php` |

### Default Admin Credentials

```
Email: admin@example.com
Password: admin123
```

⚠️ **Change these before going live!**

---

## 📦 Installation

### Step 1: Download/Clone

```bash
# Clone the repository
git clone https://github.com/yourusername/ravi-cabinet.git

# Or download and extract to XAMPP htdocs folder
# Path: C:\xampp\htdocs\RAVI WEBSITE\
```

### Step 2: Firebase Setup

1. Go to [Firebase Console](https://console.firebase.google.com/)
2. Create a new project or select existing
3. Enable Realtime Database
4. Copy your database URL
5. Update `ravi(htdocs)FIREBASE-PHP/config.php`:

```php
<?php
$databaseURL = "https://YOUR-PROJECT-default-rtdb.firebaseio.com";
?>
```

### Step 3: Set Firebase Rules

In Firebase Console → Realtime Database → Rules:

**Development (Testing):**
```json
{
  "rules": {
    "appointments": {
      ".read": true,
      ".write": true
    }
  }
}
```

**Production (Secure):**
```json
{
  "rules": {
    "appointments": {
      ".read": "auth != null",
      ".write": true,
      "$appointmentId": {
        ".validate": "newData.hasChildren(['name', 'phone', 'email', 'service', 'message', 'timestamp', 'status'])"
      }
    }
  }
}
```

### Step 4: Test Installation

1. Open `http://localhost/RAVI%20WEBSITE/test_database.php`
2. Should show "Firebase connection successful"
3. Click "Create Test Appointment"
4. Verify in Firebase Console

---

## ⚙️ Configuration

### Admin Credentials

Edit `PHP/adminlogin.php` (lines 28-29):

```php
$admin_email = "your-email@example.com";
$admin_password = "your-secure-password";
```

### Database URL

Edit `ravi(htdocs)FIREBASE-PHP/config.php`:

```php
$databaseURL = "https://your-project-default-rtdb.firebaseio.com";
```

### Service Types

Edit `PHP/forms.php` to customize service options:

```html
<select name="service" required>
    <option value="">Select Service</option>
    <option value="kitchen">Kitchen Cabinets</option>
    <option value="bedroom">Bedroom Wardrobes</option>
    <option value="office">Office Solutions</option>
    <!-- Add more options -->
</select>
```

---

## 📖 Usage Guide

### For Customers

#### Booking an Appointment

1. Visit the website homepage
2. Click "Book Appointment" or navigate to Booking page
3. Fill in the form:
   - Name (required)
   - Phone (required)
   - Email (required)
   - Service type (required)
   - Location (optional)
   - Message (required)
4. Click "Send Request"
5. Receive confirmation message

#### Browsing the Website

- **Home** - View services, features, and statistics
- **Gallery** - Click images to view full-screen
- **About** - Learn about the company and team
- **Contact** - Get in touch via form or social media

### For Administrators

#### Logging In

1. Navigate to `adminlogin.php`
2. Enter email and password
3. Click "Sign In"
4. Redirects to dashboard

#### Managing Appointments

**Search:**
- Type in search box to filter by any field
- Results update instantly

**Filter:**
- Click "All" to show all appointments
- Click "Pending" to show only pending
- Click "Completed" to show only completed

**View Details:**
- Click "View" button on any appointment
- Modal opens with full information
- Click phone to call, email to send message
- Press ESC or click X to close

**Mark Complete:**
- Click "Complete" button on pending appointments
- Status changes to completed
- Page refreshes automatically

**Delete:**
- Click trash icon on any appointment
- Confirm deletion
- Appointment removed from database

**Bulk Operations:**
- Check multiple appointment checkboxes
- Click "Delete Selected" button
- Confirm bulk deletion
- All selected appointments removed

**Print:**
- Click "Print" button
- Print dialog opens
- Print or save as PDF

---

## 🎛️ Admin Dashboard

### Dashboard Overview

The admin dashboard provides a comprehensive view of all appointments with powerful management tools.

#### Statistics Cards

- **Total Appointments** - All appointments in database
- **Pending Requests** - Awaiting action
- **Completed** - Finished appointments

#### Appointment Table

Displays all appointments with columns:
- Checkbox (for bulk selection)
- Date & Time
- Name
- Contact (phone)
- Email
- Service
- Location
- Status (badge)
- Actions (buttons)

#### Features

**Search & Filter:**
- Real-time search across all fields
- Filter by status (All/Pending/Completed)
- Instant results

**View Details Modal:**
- Full appointment information
- Scrollable content
- Clickable phone/email
- Modern card design
- ESC key support

**Bulk Operations:**
- Select multiple appointments
- Delete in bulk
- Confirmation dialogs

**Print View:**
- Clean, print-friendly format
- Hides unnecessary elements
- Professional appearance

#### Keyboard Shortcuts

- `ESC` - Close modal
- `Tab` - Navigate elements
- `Enter` - Activate button
- `Space` - Toggle checkbox

---

## 🌐 Website Features

### Homepage Animations

**Scroll Reveal:**
- Elements fade in and slide up as you scroll
- Staggered animations for cards
- Smooth transitions

**Interactive Elements:**
- Floating logo animation
- Pulsing CTA buttons
- Hover effects on cards
- Service cards with image zoom

**Statistics Counter:**
- Numbers count up from 0
- Triggers when visible
- Smooth animation

### Gallery Features

**Image Lightbox:**
- Click any image to view full-screen
- Navigate with arrow buttons or keyboard (← →)
- Close with X button or ESC key
- Click outside to close

**Search & Filter:**
- Search bar with animated focus
- Filter buttons with ripple effect
- Real-time filtering

**Image Effects:**
- Zoom on hover
- Glowing shadow
- Smooth transitions

### Responsive Design

**Desktop (1920x1080):**
- Full layout with all features
- Wide table view
- Large statistics cards

**Laptop (1366x768):**
- Optimized spacing
- Readable text
- All features accessible

**Tablet (768x1024):**
- Stacked layout
- Touch-friendly buttons
- Scrollable table

**Mobile (375x667):**
- Single column layout
- Large touch targets
- Horizontal scroll for table
- Optimized modal

---

## 💾 Database Structure

### Firebase Schema

```json
{
  "appointments": {
    "-UniqueID1": {
      "name": "John Doe",
      "phone": "09123456789",
      "email": "john@example.com",
      "address": "Manila, Philippines",
      "service": "kitchen",
      "message": "Need custom kitchen cabinets",
      "timestamp": "2026-03-07 14:30:00",
      "status": "pending"
    },
    "-UniqueID2": {
      "name": "Jane Smith",
      "phone": "09876543210",
      "email": "jane@example.com",
      "address": "Quezon City",
      "service": "bedroom",
      "message": "Custom wardrobe needed",
      "timestamp": "2026-03-07 15:45:00",
      "status": "completed"
    }
  }
}
```

### Field Descriptions

| Field | Type | Required | Description |
|-------|------|----------|-------------|
| name | string | Yes | Customer's full name |
| phone | string | Yes | Contact phone number |
| email | string | Yes | Valid email address |
| address | string | No | Project location |
| service | string | Yes | Type of service (kitchen, bedroom, office, etc.) |
| message | string | Yes | Project description/details |
| timestamp | string | Auto | Submission date/time (YYYY-MM-DD HH:MM:SS) |
| status | string | Auto | pending or completed |

---

## 🔒 Security

### Current Security Features

- ✅ Session-based authentication
- ✅ Input validation and sanitization
- ✅ XSS protection (htmlspecialchars)
- ✅ Email format validation
- ✅ Confirmation dialogs for destructive actions
- ✅ Secure form submission

### Recommended for Production

**1. Change Admin Credentials**
```php
// In PHP/adminlogin.php
$admin_email = "your-secure-email@domain.com";
$admin_password = password_hash("your-strong-password", PASSWORD_DEFAULT);
```

**2. Enable HTTPS**
- Get SSL certificate
- Force HTTPS redirects
- Update Firebase rules

**3. Configure Firebase Security**
- Implement authentication
- Set strict read/write rules
- Enable audit logging

**4. Add CSRF Protection**
```php
// Generate token
$_SESSION['csrf_token'] = bin2hex(random_bytes(32));

// Validate on submission
if ($_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    die('Invalid request');
}
```

**5. Rate Limiting**
- Limit form submissions per IP
- Prevent brute force attacks
- Implement CAPTCHA

---

## 🐛 Troubleshooting

### Common Issues

#### Issue: "Firebase connection failed"

**Solutions:**
1. Check database URL in `config.php`
2. Verify Firebase rules allow read/write
3. Check internet connection
4. Ensure cURL is enabled in PHP

#### Issue: "Permission denied" in Firebase

**Solutions:**
1. Go to Firebase Console → Rules
2. Set rules to allow write access
3. Click "Publish"
4. Wait 30 seconds for propagation

#### Issue: "Session cannot be started"

**Solutions:**
1. Ensure `session_start()` is at the very top of file
2. No output before `session_start()`
3. Check for BOM in PHP files

#### Issue: "Cannot access offset of type string"

**Solutions:**
1. Validate data is array before accessing
2. Use `is_array()` check
3. Filter non-array entries

#### Issue: Form submission not working

**Solutions:**
1. Check XAMPP Apache is running
2. Verify database URL is correct
3. Check browser console for errors
4. Test with `test_database.php`

#### Issue: Admin page not showing appointments

**Solutions:**
1. Verify data exists in Firebase Console
2. Check if logged in (session active)
3. Check browser console for errors
4. Verify `firebaseRDB.php` is included

### Testing Tools

**Test Database Connection:**
```
http://localhost/RAVI%20WEBSITE/test_database.php
```

**Check Firebase Directly:**
```
https://your-project-default-rtdb.firebaseio.com/appointments.json
```

**Browser Console:**
- Press F12
- Check Console tab for errors
- Check Network tab for failed requests

---

## 📁 File Structure

```
RAVI WEBSITE/
│
├── index.php                    # Root redirect
│
├── PHP/                         # Main application files
│   ├── index.php               # Homepage
│   ├── gallery.php             # Gallery page
│   ├── aboutus.php             # About page
│   ├── contactus.php           # Contact page
│   ├── forms.php               # Booking form
│   ├── submit_form.php         # Form handler
│   ├── adminlogin.php          # Admin login
│   ├── adminpage.php           # Admin dashboard
│   ├── header.php              # Header component
│   ├── footer.php              # Footer component
│   └── slider.php              # Background slider
│
├── CSS/                         # Stylesheets
│   ├── index.css               # Homepage styles
│   ├── gallery.css             # Gallery styles
│   ├── aboutus.css             # About styles
│   ├── contactus.css           # Contact styles
│   ├── forms.css               # Form styles
│   ├── adminlogin.css          # Login styles
│   ├── adminpage.css           # Dashboard styles
│   ├── header.css              # Header styles
│   ├── footer.css              # Footer styles
│   ├── slider.css              # Slider styles
│   └── main-components.css     # Shared components
│
├── JS/                          # JavaScript files
│   ├── script.js               # Main scripts
│   └── modern-features.js      # Animations & features
│
├── ravi(htdocs)FIREBASE-PHP/   # Firebase integration
│   ├── config.php              # Database URL
│   ├── firebaseRDB.php         # Firebase class
│   ├── index.php               # Admin panel
│   ├── add.php                 # Add records
│   ├── edit.php                # Edit records
│   └── delete.php              # Delete records
│
├── test_database.php            # Testing tool
├── diagnose_firebase.php        # Diagnostic tool
│
└── Documentation/               # All documentation files
    ├── README.md               # This file
    ├── START_HERE.md           # Quick start guide
    ├── SYSTEM_ARCHITECTURE.md  # Technical architecture
    ├── DATABASE_SETUP_GUIDE.md # Database setup
    └── ...                     # Other guides
```

---

## 🎨 Customization

### Changing Colors

Edit CSS variables in `CSS/main-components.css`:

```css
:root {
    --primary-gold: #A67C52;
    --dark-bg: #1a1a1a;
    --light-bg: #f8f9fa;
    /* Add more custom colors */
}
```

### Adding Service Types

Edit `PHP/forms.php`:

```html
<option value="custom-service">Custom Service Name</option>
```

### Modifying Email Templates

Edit `PHP/submit_form.php` to add email notifications:

```php
// After successful Firebase insert
mail($to, $subject, $message, $headers);
```

### Changing Logo

Replace logo URL in `PHP/index.php`:

```html
<img src="YOUR-LOGO-URL" alt="Company Logo">
```

---

## 📊 Performance

### Optimization Features

- ✅ Lazy loading for images
- ✅ Minified CSS/JS (production)
- ✅ CDN for libraries
- ✅ Browser caching
- ✅ Efficient database queries
- ✅ GPU-accelerated animations
## 🚀 Deployment

### ⚠️ Important Notice

**This project is NOT production-ready.** It was created for learning purposes and requires significant security improvements before being deployed to a live environment.

### Before Deploying (Critical)

**Security Requirements:**
- [ ] Implement proper password hashing
- [ ] Add CSRF protection
- [ ] Implement rate limiting
- [ ] Secure Firebase rules
- [ ] Add input validation and sanitization
- [ ] Enable HTTPS
- [ ] Remove hardcoded credentials
- [ ] Add environment variables
- [ ] Implement proper error handling
- [ ] Add security headers

**Testing Requirements:**
- [ ] Test all features thoroughly
- [ ] Test on multiple browsers
- [ ] Test on mobile devices
- [ ] Perform security audit
- [ ] Load testing
- [ ] Penetration testing

### For Learning/Development Only

If you want to use this for learning:

1. **Local Development**: Use XAMPP/WAMP for local testing
2. **Firebase**: Use test mode with restricted access
3. **Testing**: Create test accounts and data
4. **Learning**: Study the code and improve it
## 🤝 Contributing

This is a personal learning project, but contributions, suggestions, and feedback are welcome! If you'd like to help improve this project:

### How to Contribute

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/ImprovementName`)
3. Make your improvements
4. Test your changes
5. Commit your changes (`git commit -m 'Add improvement: description'`)
6. Push to the branch (`git push origin feature/ImprovementName`)
7. Open a Pull Request with a clear description

### Areas Where Help is Needed

- Security improvements
- Code refactoring and organization
- Bug fixes
- Documentation improvements
- UI/UX enhancements
- Performance optimization
- Testing implementation
- Best practices implementation

### Code Style
## 👥 Author

- **Developer** - Personal learning project - [GitHub](https://github.com/yourusername)

### Learning Journey

## 🙏 Acknowledgments

### Technologies & Resources

- **Firebase** - For providing free Realtime Database services
- **Font Awesome** - For the icon library
- **Google Fonts** - For typography (Raleway, Poppins)
- **Unsplash** - For placeholder images
- **XAMPP** - For local development environment

## 📞 Support & Questions

### Getting Help

- 🐛 **Issues**: [GitHub Issues](https://github.com/yourusername/ravi-cabinet/issues)
- 💬 **Discussions**: Feel free to open a discussion for questions
- 📧 **Contact**: Open an issue for any questions or suggestions

### FAQ

**Q: Is this production-ready?**
A: No, this is a learning project. It needs security improvements and additional features before production use.

**Q: Can I use this for learning?**
A: Absolutely! That's what it's for. Feel free to study, modify, and learn from the code.

**Q: Can I use this for my own project?**
A: Yes, under MIT license. However, please improve security and add necessary features first.

**Q: Can I contribute?**
A: Yes! Contributions, suggestions, and improvements are welcome.

**Q: Is this actively maintained?**
A: This is a personal project maintained as time permits. Updates may be sporadic.

**Q: Where can I learn more about the technologies used?**
A: Check the documentation links in the README and explore the official docs for PHP, Firebase, and JavaScript.
Even if you don't want to contribute code, feedback is valuable:
- Report bugs or issues
- Suggest improvements
- Share best practices
- Point out security concerns
- Recommend better approaches
### Environment Variables

For production, use environment variables:

```php
// config.php
$databaseURL = getenv('FIREBASE_URL');
$admin_email = getenv('ADMIN_EMAIL');
$admin_password = getenv('ADMIN_PASSWORD');
```

---

## 🤝 Contributing

Contributions are welcome! Please follow these guidelines:

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

### Code Style

- Use consistent indentation (2 spaces)
- Follow PSR-12 for PHP
- Use meaningful variable names
- Comment complex logic
- Test before submitting

---

## 📝 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

---

## 👥 Authors

- **Your Name** - Initial work - [YourGitHub](https://github.com/yourusername)

---

## � Support the Project

If you find this project helpful for learning, please consider:

- ⭐ **Star the repository** - Shows appreciation and helps others find it
- 🐛 **Report bugs** - Help identify issues and improve the code
- 💡 **Suggest improvements** - Share ideas for better implementation
- 🤝 **Contribute** - Submit pull requests with improvements
- � **Share** - Help other learners discover this project
- 💬 **Provide feedback** - Let me know what could be better

### Disclaimer

This project is provided "as is" for educational purposes. Use at your own risk. The author is not responsible for any issues arising from the use of this code. Always implement proper security measures before deploying any web application.

---

**Made with ❤️ as a learning project**

*"Every expert was once a beginner. Keep learning, keep building!"*

- 📧 Email: support@example.com
- 💬 Discord: [Join our server](https://discord.gg/example)
- 📖 Documentation: [Full docs](https://docs.example.com)
- 🐛 Issues: [GitHub Issues](https://github.com/yourusername/ravi-cabinet/issues)

### FAQ

**Q: Is this free to use?**
A: Yes, the code is open source under MIT license.
## 📈 Future Improvements

### Areas for Enhancement

**Security Improvements:**
- [ ] Implement proper password hashing (bcrypt/Argon2)
- [ ] Add CSRF token protection
- [ ] Implement rate limiting
- [ ] Add input sanitization and validation
- [ ] Secure Firebase rules for production
- [ ] Add SQL injection prevention (if migrating to SQL)
- [ ] Implement proper session management

**Feature Additions:**
- [ ] Email notifications for new appointments
- [ ] SMS notifications
- [ ] Calendar integration (Google Calendar, iCal)
- [ ] Customer portal for tracking appointments
- [ ] Payment integration (PayPal, Stripe)
- [ ] Multi-language support
- [ ] Advanced analytics dashboard
- [ ] Export data to CSV/Excel
- [ ] Appointment reminders
- [ ] Customer feedback system

**Code Quality:**
- [ ] Refactor code into MVC architecture
- [ ] Add automated testing (PHPUnit)
- [ ] Implement error logging
- [ ] Add code documentation
- [ ] Use dependency injection
- [ ] Implement design patterns
- [ ] Add API endpoints (RESTful)

**Performance:**
- [ ] Implement caching (Redis/Memcached)
- [ ] Optimize database queries
- [ ] Add image optimization
- [ ] Implement lazy loading
- [ ] Use CDN for static assets
- [ ] Minify CSS/JS files
- [ ] Add service worker for PWA

**UI/UX:**
- [ ] Add dark mode toggle
- [ ] Improve accessibility (WCAG compliance)
- [ ] Add loading skeletons
- [ ] Improve mobile experience
- [ ] Add more animations
- [ ] Implement better error messages
- [ ] Add tooltips and help text
### Planned Features

- [ ] Email notifications for new appointments
## 🎯 Project Status

**Current Version**: 2.0  
**Status**: In Development 🚧  
**Last Updated**: March 7, 2026

### Development Progress

- **v2.0** (March 2026) - Added animations, enhanced admin dashboard
- **v1.5** (March 2026) - Fixed bugs, improved UI
- **v1.0** (March 2026) - Initial release

### Known Limitations

This is a learning project and has several areas that could be improved:

**Security:**
- Basic authentication (hardcoded credentials)
- No password hashing
- No CSRF protection implemented
- Firebase rules need hardening for production

**Features:**
- No email notifications
- No user registration system
- Limited error handling
- No data backup system
- No admin user management

**Code Quality:**
- Could benefit from better code organization
- Limited input validation in some areas
- No automated testing
- Could use more modular architecture

**Performance:**
- No caching implemented
- Could optimize database queries
- Images not optimized
- No CDN integration

## 🎯 Project Status

**Current Version**: 2.0  
**Status**: Production Ready ✅  
**Last Updated**: March 7, 2026

### Version History

- **v2.0** (March 2026) - Added animations, enhanced admin dashboard
- **v1.5** (March 2026) - Fixed bugs, improved UI
- **v1.0** (March 2026) - Initial release

---

## 📸 Screenshots

### Homepage
![Homepage](screenshots/homepage.png)

### Gallery
![Gallery](screenshots/gallery.png)

### Admin Dashboard
![Admin Dashboard](screenshots/admin-dashboard.png)

### Booking Form
![Booking Form](screenshots/booking-form.png)

---

## 🌟 Star History

[![Star History Chart](https://api.star-history.com/svg?repos=yourusername/ravi-cabinet&type=Date)](https://star-history.com/#yourusername/ravi-cabinet&Date)

---

## 💖 Support the Project

If you find this project helpful, please consider:

- ⭐ Starring the repository
- 🐛 Reporting bugs
- 💡 Suggesting features
- 🤝 Contributing code
- 📢 Sharing with others

---

**Made with ❤️ by the RAVI Team**

---

**Quick Links:**
- [Installation](#installation)
- [Configuration](#configuration)
- [Usage Guide](#usage-guide)
- [Troubleshooting](#troubleshooting)
- [Contributing](#contributing)

---

*Last updated: March 7, 2026*
