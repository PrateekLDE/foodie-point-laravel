## What I Built

- **Admin Login System**  
  A simple login system for the restaurant owner to securely access the admin dashboard.

- **Mobile-Friendly Interface**  
  The application is designed to work well on mobile devices since the owner may update the menu from their phone and customers will view it on their phones.

- **Add Daily Specials**  
  The owner can add menu items for a specific date with the following details:
  - Food name  
  - Price  
  - Meal period (breakfast, lunch, dinner, etc.)  
  - Optional description

- **Edit and Delete Menu Items**  
  The owner can update menu items if there is a mistake or remove items that are no longer needed.

- **Mark Items as Sold Out**  
  Menu items can be marked as sold out so customers know when a dish is no longer available.

- **Copy Menu from a Previous Date**  
  The owner can quickly copy specials from a past date to save time when similar dishes are served again.

- **Advance Menu Creation**  
  The owner can add menu items for upcoming dates in advance if they already know the specials.

- **Customer Menu View (Public Page)**  
  Customers can view the restaurant’s daily specials on a public page without needing to log in.

- **QR Code Access**  
  A QR code can be placed on restaurant tables, allowing customers to scan it and directly open the page showing the current menu.

- **Simple Admin Form**  
  The menu management interface is intentionally kept simple so that a non-technical owner can easily update daily specials.


---

## What I Left Out and Why

- **Food Images for Menu Items**  
  I kept the menu text-based to keep the system simple. Adding images would require image uploads, storage management, and additional UI work.

- **Customer Feedback or Ratings**  
  Customers currently only view the menu. Allowing ratings or feedback would require moderation and additional features which were not necessary for the first version.

- **Analytics or QR Scan Tracking**  
  The system does not track how many customers scan the QR code or which items are viewed the most. This could be useful in the future but was not required for the core functionality.

- **Multiple Staff/Admin Accounts**  
  The current system assumes a single owner managing the menu. If the restaurant grows, staff roles with limited permissions could be added later.

- **Table-Specific QR Codes**  
  Currently the QR code simply opens the menu page. In the future, separate QR codes per table could support features like table ordering.

- **Online Ordering System**  
  Customers can only view the menu. Ordering functionality was not included because the main requirement was to display daily specials.


## What Would Change If This Needed to Go Live Next Week?

If the application needed to go live next week, I would focus not only on the code but also on a few practical aspects required to run it reliably in a real restaurant environment.

- **Reliable Hosting**
  The application would need to be deployed on a stable hosting platform so customers can access it anytime. The QR code placed on tables would point to this live URL.

- **Domain and HTTPS**
  A proper domain name should be set up and HTTPS enabled to ensure secure access and avoid browser warnings.

- **Mobile Testing**
  Since both the owner and customers will mostly use their phones, I would test the application across different mobile screen sizes and browsers to ensure a smooth experience.

- **Performance Optimization**
  The page should load quickly even on slower networks. This may include optimizing database queries, reducing unnecessary assets, and keeping the UI lightweight.

- **Basic Security Checks**
  Ensure proper validation, authentication for the admin panel, and protection against common issues like unauthorized access or invalid form submissions.

- **Database Backups**
  Regular database backups should be set up so that menu data can be restored if something goes wrong.

- **Error Handling and Logging**
  Basic error logging should be enabled so issues can be identified and fixed quickly if something breaks.

- **Owner Training / Simple Documentation**
  Since the owner mentioned they are not very tech-savvy, I would provide a short guide explaining how to log in, add menu items, edit them, and mark items as sold out.

- **Content and Menu Maintenance Plan**
  I would discuss with the owner how often they plan to update the menu and who will be responsible for maintaining it daily.

- **QR Code Placement**
  The QR codes should be printed clearly and placed on tables or near ordering areas so customers can easily scan them.

- **Basic Monitoring**
  It would be helpful to have simple monitoring in place to ensure the website stays online and accessible.

## Where Did AI Help, and Where Did It Fall Short?

- **Idea Exploration**
  AI was helpful in brainstorming possible approaches for the application. It helped explore different ways to structure the system and think about potential features.

- **Initial Code Suggestions**
  AI helped generate initial examples for things like route structure, controller logic, and UI layout ideas. These examples provided a starting point that I could refine and adapt.

- **Refactoring and Wording**
  AI was useful for improving documentation, prompts, and explanations. It helped clean up wording and structure some of the written sections of the project.

- **Faster Iteration**
  Instead of spending time searching for syntax or small implementation patterns, AI helped quickly generate examples that could be tested and adjusted.

### Where AI Fell Short

- **Over-Engineering Suggestions**
  Sometimes AI suggested solutions that were more complex than needed for this problem. Since the restaurant owner only needed a simple system for daily specials, I had to simplify those suggestions and focus on the core requirement.

- **Context Awareness**
  AI occasionally lacked full context about the real-world scenario (a small family-owned restaurant). Some generated ideas assumed a larger or more complex system.

- **Code Adjustments**
  In some cases, the generated code required manual adjustments to match the exact Laravel structure or to keep the interface simple and mobile-friendly.

- **Final Decision Making**
  AI was helpful for generating ideas and examples, but the final decisions about what to build, what to simplify, and what to leave out required manual judgment.

Overall, AI acted as a helpful assistant for brainstorming and speeding up small tasks, but the final implementation and design decisions required human review and refinement.  

## Who Else Did You Consider?

While designing the application, I mainly considered two primary users: the **restaurant owner** and the **customers**.

- **Restaurant Owner (Primary Admin User)**  
  The owner needs a very simple way to update daily specials quickly. Since they mentioned they are not very tech-savvy, the admin interface was designed to be minimal and easy to use, even from a mobile phone.

- **Customers**  
  Customers need a quick and frictionless way to see the menu. Requiring login or downloading an app would create unnecessary friction, so the menu is accessible directly through a QR code scan in the browser.

- **Restaurant Staff**  
  Although staff members are not direct users of the system in this version, the application indirectly helps them by reducing the number of phone calls asking about daily specials. This allows them to focus more on serving customers.

- **Future Staff Usage**  
  In the future, staff members could be given limited access to update menu availability during the day, such as marking items as sold out or making small corrections.

- **Walk-in Customers Near the Restaurant**  
  Some customers may check the menu before entering the restaurant if the QR code is displayed outside. Making the menu publicly accessible helps potential customers quickly see what is available.

- **Customers with Different Devices**  
  Since customers will use different phones and browsers, the interface was designed to be lightweight and mobile-friendly so it works reliably across devices.

- **Restaurant Operations**  
  I also considered how the system fits into the daily routine of the restaurant. Updating the menu should take only a few minutes and should not interrupt normal operations.

- **Maintenance Responsibility**  
  Since small restaurants may not have technical staff, the system needed to be simple enough for the owner to maintain without needing technical help frequently.

Overall, the goal was to keep the system simple for the owner and convenient for customers, while leaving room to support additional users such as staff members in the future.