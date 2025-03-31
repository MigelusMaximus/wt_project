# Project Web Technologies

### 🚀 Technologies Used

| Technology            | Purpose / Use |
|-----------------------|----------------|
| **Symfony**           | Main PHP framework for routing, controllers, templates, forms, security, etc. |
| **Doctrine ORM**      | Maps PHP objects to MySQL tables (`Member`, `Event`, etc.). Handles database operations. |
| **MySQL**             | Relational database storing members, events, and their relationships. Managed via MySQL Workbench. |
| **Twig**              | Templating engine to render dynamic HTML views (`.html.twig` files). |
| **PHP 8 Attributes**  | Used in entities to define database structure with `#[ORM\Column]`, `#[ORM\Entity]`, etc. |
| **Symfony Routing**   | Maps URLs to controller methods using `#[Route(...)]`. |
| **Symfony Forms**     | Generates and handles forms (e.g., for creating or editing members and events). |
| **Symfony Security**  | Handles authentication, login, and access control. |
| **Bootstrap**         | Frontend CSS framework for UI styling (buttons, tables, layout). |
| **MySQL Workbench**   | GUI tool to visually manage database structure and data. |
| **Flash Messages**    | Symfony feature for showing one-time UI alerts (e.g., success messages). |
| **ManyToMany Relationships** | Doctrine relationships between `Member` and `Event`, stored in a join table (`member_event`). |
| **Routing Attributes**| PHP 8+ attributes used for route declarations inside controller methods. |
| **Composer**          | Dependency manager that installs Symfony and other PHP packages. |


### 🗃️ Database Architecture

#### `member` table

| Field       | Type                 | Description               |
|-------------|----------------------|---------------------------|
| `id`        | `INT` (PK, AUTO_INCREMENT) | Unique identifier for the member |
| `name`      | `VARCHAR(255)`       | Member’s full name        |
| `email`     | `VARCHAR(255)`       | Member’s email address    |
| `joined_at` | `DATETIME_IMMUTABLE` | Date the member joined    |

---

#### `event` table

| Field       | Type                 | Description                |
|-------------|----------------------|----------------------------|
| `id`        | `INT` (PK, AUTO_INCREMENT) | Unique identifier for the event |
| `title`     | `VARCHAR(255)`       | Title of the event         |
| `date`      | `DATETIME_IMMUTABLE` | Date of the event          |
| `location`  | `VARCHAR(255)`       | Location where event takes place |

---

#### `member_event` table (Join Table for ManyToMany)

| Field         | Type | Description                              |
|---------------|------|------------------------------------------|
| `member_id`   | `INT` (FK) | Foreign key to `member(id)`         |
| `event_id`    | `INT` (FK) | Foreign key to `event(id)`          |

- Stores the ManyToMany relationship between members and events.
- A single member can be in multiple events, and an event can have many members.
- Automatically handled by Doctrine.

