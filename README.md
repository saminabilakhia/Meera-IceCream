# 🍦 Meera Icecreams Website

A complete professional website for Meera Icecreams with franchise management system built using HTML, CSS, JavaScript, PHP, and MySQL.

## 🌟 Features

- **Responsive Design**: Mobile-friendly ice cream themed website
- **6 Main Pages**: Home, Story, Flavors, Stores, Franchise, Contact
- **Franchise System**: Complete application form with MySQL database
- **Admin Panel**: Secure dashboard to manage franchise applications
- **Interactive Gallery**: Filterable flavor gallery with animations
- **Contact Forms**: Working contact and franchise forms
- **Professional Design**: Pastel color scheme with smooth animations

## 🚀 Quick Setup (XAMPP)

### 1. Database Setup
1. Start XAMPP (Apache + MySQL)
2. Open phpMyAdmin (http://localhost/phpmyadmin)
3. Import the database:
   - Create new database or use existing
   - Import `sql/meera_icecream.sql`

### 2. Configuration
1. Update database credentials in `includes/db_connect.php` if needed:
   ```php
   $servername = "localhost";
   $username = "root";
   $password = "";
   $dbname = "meera_icecream";
   ```

### 3. Access the Website
- **Main Website**: http://localhost/meera_icecream/
- **Admin Panel**: http://localhost/meera_icecream/admin/login.php
- **Admin Login**: username: `admin`, password: `admin123`

## 📁 Project Structure

```
meera_icecream/
├── index.html              # Home page
├── story.html              # Company story
├── flavors.html            # Product gallery
├── stores.html             # Store locations
├── franchise.html          # Franchise information & form
├── contact.html            # Contact page
├── submit_franchise.php    # Franchise form handler
├── send_message.php        # Contact form handler
├── admin/
│   ├── login.php          # Admin login
│   ├── dashboard.php      # Franchise applications dashboard
│   └── logout.php         # Logout script
├── includes/
│   ├── db_connect.php     # Database connection
│   ├── header.php         # Header template
│   └── footer.php         # Footer template
├── assets/
│   ├── css/style.css      # Main stylesheet
│   ├── js/main.js         # JavaScript functionality
│   └── img/               # Images folder
└── sql/
    └── meera_icecream.sql # Database structure
```

## 🎨 Design Features

- **Color Palette**: Pink (#F8BBD0), Cream (#FFF8E7), Chocolate (#6B4226), Mint Blue (#B3E5FC)
- **Typography**: Poppins (headings), Nunito Sans (body)
- **Animations**: Smooth hover effects, mobile navigation
- **Responsive**: Works on desktop, tablet, and mobile devices

## 🔧 Functionality

### Public Features
- **Hero Section**: Eye-catching landing with call-to-action buttons
- **Flavor Gallery**: Filterable product showcase (All/Cones/Cups/Family Packs)
- **Store Locator**: List of all outlet locations with details
- **Franchise Application**: Complete form with validation and database storage
- **Contact Form**: Working contact form with validation
- **Mobile Navigation**: Responsive hamburger menu

### Admin Features
- **Secure Login**: Password-protected admin access
- **Dashboard**: View all franchise applications
- **Application Management**: View details, delete applications
- **Statistics**: Quick overview of applications (total, weekly, monthly)
- **Responsive Admin Panel**: Works on all devices

## 🗄️ Database Tables

### `franchise_requests`
- Stores all franchise application data
- Fields: id, name, email, phone, city, investment, message, created_at

### `admin_users`
- Admin authentication
- Default admin: username `admin`, password `admin123`

## 🛠️ Customization

### Adding New Flavors
1. Add images to `assets/img/flavors/`
2. Update `flavors.html` with new flavor cards
3. Set appropriate `data-category` for filtering

### Changing Colors
Update CSS variables in `assets/css/style.css`:
```css
:root {
    --pink: #F8BBD0;
    --cream: #FFF8E7;
    --chocolate: #6B4226;
    --mint: #B3E5FC;
}
```

### Adding New Store Locations
Update `stores.html` with new store cards following the existing format.

## 📱 Browser Support

- Chrome (recommended)
- Firefox
- Safari
- Edge
- Mobile browsers

## 🔒 Security Notes

- Change default admin password in production
- Use HTTPS in production environment
- Validate and sanitize all user inputs
- Regular database backups recommended

## 📞 Support

For any issues or customizations, refer to the code comments or contact the development team.

---

**🍦 Meera Icecreams - Serving happiness, one scoop at a time!**