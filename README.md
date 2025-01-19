# Parks and Facilities Manager Plugin - [Live Demo](https://plugins.rohantgeorge.ca/parks-directory/)

## Description

The **Parks and Facilities Manager** is a custom WordPress plugin that helps you manage parks and their details with ease. It allows you to:

- Add, edit, and display parks as a custom post type.
- Categorize parks by facilities using a custom taxonomy.
- Include meta details like location and hours (weekdays and weekends).
- Display parks on the front-end using a shortcode with featured images and Google Maps integration for locations.

---

## Installation

### 1. Upload the Plugin

1. Download the plugin as a `.zip` file.
2. In your WordPress admin dashboard, go to **Plugins > Add New**.
3. Click the **Upload Plugin** button.
4. Choose the `.zip` file and click **Install Now**.

### 2. Activate the Plugin

1. After installation, click **Activate Plugin**.

### 3. Add Parks

1. Go to **Parks** in the WordPress admin menu.
2. Click **Add New** to create a park.
3. Fill in the details:
   - **Title**: The name of the park.
   - **Location**: Specify the park's location.
   - **Hours**: Add hours for weekdays and weekends.
   - **Facilities**: Categorize the park (e.g., Ice Rink, Water Fountain).
   - **Featured Image**: Add an image for the park.

### 4. Display Parks on Your Site

1. Use the `[park_list]` shortcode to display all parks in a styled format.
2. Example:
   ```
   [park_list]
   ```
3. The shortcode will show:
   - Park name
   - Featured image
   - Location (clickable link to Google Maps)
   - Weekday and weekend hours
   - Short description

---

## Features

### Custom Post Type: **Parks**

- Manage parks with detailed meta fields (location, hours).
- Include featured images for visual appeal.

### Custom Taxonomy: **Facilities**

- Categorize parks using facilities like Ice Rink, Water Fountain, etc.
- Facilities appear in the park editor and can be managed globally.

### Shortcode: `[park_list]`

- Display all parks on the front-end in a styled layout.
- Each park shows:
  - Name
  - Featured Image
  - Location (clickable link to Google Maps)
  - Weekday and weekend hours
  - Truncated description

---

## Styling

- Basic CSS is included for layout and formatting.
- You can customize styles by editing the `style.css` file located in the plugin folder or adding custom styles in your theme.

---

## Google Maps Integration

- Locations entered in the meta field are clickable.
- Clicking the location takes the user to Google Maps for navigation.

---

## Support

For issues or feature requests, please contact the plugin author:

- **Author**: Rohan T George
- **Email**: rohantgeorge05@gmail.com
- **Website**: [rohantgeorge.ca](https://www.rohantgeorge.ca)

---

## Changelog

### Version 1.0.0

- Initial release.
- Custom post type "Parks" with location, hours, and facilities taxonomy.
- Shortcode `[park_list]` for front-end display.
- Google Maps integration for locations.
- Basic CSS for styling.
