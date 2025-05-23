# Symfony Blog Techlab

Base de donnée initial : PostgreSQL

système de Blog avec le système de sécurité avec symfony

Pour générer des données dans la base de donnée

```bash
symfony console doctrine:fixtures:load
```

User authentication

`ROLE_ADMIN`

**email :** admin@domain.com

**password :** Admin@123

---

`ROLE_USER`

**email :** user@domain.com

**password :** Admin@123

---

`Other user with ROLE_USER`

**password :** 123456789

---

Pour lancer le projet

```bash
npm run dev
```

OU

```bash
symfony serve
npm run watch
```

> Hasintsoa
