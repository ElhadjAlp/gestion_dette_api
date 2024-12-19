L’erreur indique que votre application Symfony ne peut pas se connecter au serveur PostgreSQL. Voici les étapes pour résoudre ce problème :

---

### **1. Vérifiez si le serveur PostgreSQL est actif**
Assurez-vous que PostgreSQL est bien démarré sur votre machine :

- **Sous Linux** :
  ```bash
  sudo systemctl status postgresql
  ```
  S'il n'est pas actif, démarrez-le avec :
  ```bash
  sudo systemctl start postgresql
  ```

- **Sous Windows** :
  - Ouvrez l’application **Services** (tapez `services.msc` dans le menu Exécuter).
  - Cherchez **PostgreSQL** dans la liste et assurez-vous qu’il est démarré.

- **Sous macOS** (si PostgreSQL a été installé via Homebrew) :
  ```bash
  brew services list
  brew services start postgresql
  ```

---

### **2. Vérifiez le port et l’hôte**
PostgreSQL utilise généralement le port `5432`. Vérifiez que ce port est en écoute en exécutant :

```bash
netstat -nlt | grep 5432
```

S'il n'y a pas de service écoutant sur le port `5432`, mettez à jour votre configuration PostgreSQL pour utiliser le bon port ou démarrez le service sur ce port.

---

### **3. Testez la connexion PostgreSQL**
Essayez de vous connecter à PostgreSQL avec l'outil en ligne de commande `psql` ou un client comme **pgAdmin** :

- **Ligne de commande** :
  ```bash
  psql -U postgres -h 127.0.0.1 -p 5432
  ```

Si la connexion échoue :
- Vérifiez que le nom d’utilisateur et le mot de passe dans votre fichier `.env` sont corrects.
- Vérifiez que les règles d'accès dans `pg_hba.conf` autorisent les connexions locales (voir l’étape 5).

---

### **4. Vérifiez la configuration dans le fichier `.env`**
Assurez-vous que votre fichier `.env` contient les bonnes informations de connexion à la base de données :

```dotenv
DATABASE_URL="postgresql://username:password@127.0.0.1:5432/gestion_dette_api"
```

- **username** : Remplacez-le par votre utilisateur PostgreSQL (par défaut `postgres`).
- **password** : Remplacez-le par le mot de passe de cet utilisateur.
- **gestion_dette_api** : Assurez-vous que ce nom de base de données correspond à celle que vous voulez utiliser.

---

### **5. Configurez PostgreSQL pour les connexions locales**
Si le serveur fonctionne mais refuse les connexions, modifiez le fichier `pg_hba.conf` pour autoriser les connexions locales :

1. Ouvrez le fichier de configuration :
   ```bash
   sudo nano /etc/postgresql/<version>/main/pg_hba.conf
   ```

2. Assurez-vous qu'il contient une ligne comme celle-ci :
   ```
   host    all             all             127.0.0.1/32            md5
   ```

3. Redémarrez PostgreSQL pour appliquer les modifications :
   ```bash
   sudo systemctl restart postgresql
   ```

---

### **6. Créez la base de données manuellement**
Si Symfony n’arrive toujours pas à créer la base, créez-la directement depuis PostgreSQL :

1. Connectez-vous à PostgreSQL :
   ```bash
   psql -U postgres -h 127.0.0.1
   ```

2. Créez la base de données :
   ```sql
   CREATE DATABASE gestion_dette_api;
   ```

3. Quittez PostgreSQL :
   ```sql
   \q
   ```

Ensuite, relancez la commande Symfony :
```bash
php bin/console doctrine:database:create
```

---

### **7. Conseils de dépannage**
- Consultez les logs de Symfony pour plus de détails :
  ```bash
  tail -f var/log/dev.log
  ```

- Vérifiez que l’utilisateur PostgreSQL dispose des permissions nécessaires pour créer une base de données.

---

### **Résumé des commandes importantes**
```bash
# Démarrer PostgreSQL (Linux/Mac)
sudo systemctl start postgresql

# Tester la connexion
psql -U postgres -h 127.0.0.1 -p 5432

# Créer la base manuellement si nécessaire
CREATE DATABASE gestion_dette_api;

# Redémarrer PostgreSQL après modification
sudo systemctl restart postgresql
```

Avec ces étapes, votre problème devrait être résolu. Si le problème persiste, partagez votre configuration `.env` et les messages d’erreur détaillés pour une assistance supplémentaire ! 😊



# Mot de passe oublie
Sous **Ubuntu WSL** ou une distribution Linux en général, vous pouvez voir les utilisateurs existants et changer leurs mots de passe en utilisant les commandes suivantes.

### **Voir les utilisateurs sur Ubuntu WSL**

Les utilisateurs du système sont enregistrés dans le fichier `/etc/passwd`. Vous pouvez l'afficher avec la commande suivante pour voir une liste des utilisateurs :

```bash
cat /etc/passwd
```

Cela affichera une liste d'utilisateurs, chacun ayant sa propre ligne. Chaque ligne représente un utilisateur, et les informations sont séparées par des deux-points (`:`). La structure d'une ligne est généralement la suivante :

```
nom_utilisateur:x:UID:GID:commentaire:/home/nom_utilisateur:/bin/bash
```

- **nom_utilisateur** : Le nom de l'utilisateur.
- **UID** : Identifiant unique de l'utilisateur.
- **GID** : Identifiant du groupe de l'utilisateur.
- **commentaire** : Informations supplémentaires, généralement un champ vide.
- **/home/nom_utilisateur** : Le répertoire personnel de l'utilisateur.
- **/bin/bash** : Le shell utilisé par l'utilisateur.

### **Changer le mot de passe d'un utilisateur**

Pour changer le mot de passe d'un utilisateur sous **Ubuntu WSL** ou Linux, vous devez être connecté en tant qu'utilisateur avec des privilèges `sudo` ou en tant que `root`.

#### **Changer le mot de passe d'un utilisateur (avec `sudo`)**

1. **Ouvrir un terminal Ubuntu**.
2. **Utiliser la commande `passwd` pour changer le mot de passe** :
   ```bash
   sudo passwd nom_utilisateur
   ```
   Remplacez `nom_utilisateur` par le nom de l'utilisateur dont vous souhaitez changer le mot de passe.

3. Vous serez invité à entrer un **nouveau mot de passe** pour cet utilisateur et à le confirmer.

#### **Changer le mot de passe d'un utilisateur en tant que root**

Si vous êtes connecté en tant qu'utilisateur **root**, vous pouvez changer le mot de passe de n'importe quel utilisateur sans avoir besoin de `sudo`. Voici les étapes :

1. **Se connecter en tant que root** (si vous n'êtes pas déjà root) :
   ```bash
   sudo -i
   ```
   Ou si vous êtes déjà root, vous pouvez sauter cette étape.

2. **Changer le mot de passe d'un utilisateur** :
   ```bash
   passwd nom_utilisateur
   ```
   Remplacez `nom_utilisateur` par le nom de l'utilisateur dont vous souhaitez changer le mot de passe.

3. Comme précédemment, vous serez invité à entrer et confirmer le nouveau mot de passe.

### **Lister les groupes d'un utilisateur**

Pour voir à quel groupe appartient un utilisateur, vous pouvez utiliser la commande `groups` :

```bash
groups nom_utilisateur
```

Cela affichera tous les groupes auxquels appartient cet utilisateur.

### **Vérification des utilisateurs après modification**

Une fois le mot de passe modifié, vous pouvez vérifier si les utilisateurs existent toujours en consultant à nouveau le fichier `/etc/passwd` :

```bash
cat /etc/passwd
```

Cela affichera la liste des utilisateurs et vous permettra de vérifier si l'utilisateur existe toujours.

### **Résumé des commandes :**

- **Voir les utilisateurs** : 
  ```bash
  cat /etc/passwd
  ```

- **Changer le mot de passe d'un utilisateur** (en tant que root ou avec sudo) :
  ```bash
  sudo passwd nom_utilisateur
  ```

- **Voir les groupes d'un utilisateur** :
  ```bash
  groups nom_utilisateur
  ```

- **Se connecter en tant que root** (si nécessaire) :
  ```bash
  sudo -i
  ```

Cela devrait vous permettre de gérer les utilisateurs et leurs mots de passe sous Ubuntu WSL. Si vous avez d'autres questions, n'hésitez pas à demander ! 😊