# Symfony Blog Techlab

Application de blog avec système de messagerie en temp réel développé avec **symfony**, **mercure** et **react**

Base de donnée initial : PostgreSQL

Pour exécuter les migrations

```bash
symfony console doctrine:migrations:migrate
```

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

### Pour lancer le projet

#### BACKEND

```bash
npm run dev
```

OU

```bash
symfony serve
npm run watch
```

#### FRONTEND

```bash
npm run dev
```

> Hasintsoa
