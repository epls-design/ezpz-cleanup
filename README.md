# EZPZ Wordpress Starter

This plugin is a fork of [Selfish Fresh Start](https://github.com/chuckreynolds/Selfish-Fresh-Start) adapted to remove some of the unneeded bloat and fluff of native Wordpress. The plugin provides a solid foundation for Wordpress projects by cleaning up the Wordpress header, improving performance and masking some inherent security issues. This plugin is intended to be general enough that it can be installed onto any Wordpress installation without causing conflicts or issues with themes or other plugins.

## Current Operations

### Security:

- Prevents direct access to files through the admin interface (sets DISALLOW_FILE_EDIT true)
- Creates a client-admin User Role with restricted administrator rights. Keep the client out of key areas of the admin dashboard
- If a users log in fails, don't tell them which item was wrong (username/password)
- Removes WP generator version from head
- Prevents non-admin users accessing tools, options and ACF edit pages. Redirects any attempts to access.

### Bloat:

- Restricts post revisions to 20
- Removes support for emoji
- Removes WLW manifest links from head
- Removes RSD links from head
- Removes shortlink generator from head
- Removes unneeded dashboard widgets - core and plugin specific
- Remove feed links from head
- Removes pointlesss links to export, import and tools from admin menu

### Performance:
- Disables self pingback and pingback from other blogs
- Removes Hello Dolly if it exists
- Fixes bad formatting from text pasted in from Word
- Remove WP Rest API

### White Label:
- Changes login logo and brands login page
- Sets 'remember me' to checked by default on log in screen
- Replaces link in WP admin footer with link to EPLS website
- Replace admin menubar icon with EPLS logo
- Adds EPLS credit to admin dashboard footer
- Creates a Dashboard widget with EPLS support information
- Prevents users with insufficient priveleges being nagged to update core