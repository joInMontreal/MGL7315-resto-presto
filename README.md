# MGL7315-resto-presto

## H2 Installation de l'environnement locale

> *Pré-requis* :
	Installez [Virtual Box](https://www.virtualbox.org/wiki/Downloads)
	et [Vagrant](https://www.vagrantup.com/downloads.html)

- Pointez le nom de domaine sur l'IP de la machine virtuelle :
```
sudo sh -c 'echo "192.168.17.227 resto-presto.local" >> /etc/hosts'
```

- Créez un répertoire "resto" :
```
mkdir resto && cd resto
```
- Clonez l'environment :
```
git clone https://github.com/joInMontreal/MGL7315-env.git
```
- Clonez le code source :
```
git clone https://github.com/joInMontreal/MGL7315-resto-presto.git
```
- Démarrez la machine virtuelle :
```
cd MGL7315-env
vagrant up
```
- Installez l'application :
```
# connexion ssh dans la machine virtuelle
vagrant ssh

# Installez les dépendances
cd ~/resto-presto
composer install

# Installez les migrations de schema
php artisan migration

# Générez des données fictives
php artisan db:seed
```
- Ouvrez un navigateur et ouvrez : [http://resto-presto.local](http://resto-presto.local)

## H2 Accédez à la base de données sur la VM :

Utilsez votre MySQL client favoris avec pont SSH (MySQL Workbench ou Sequel Pro)

- Mysql host : 127.0.0.1
- Mysql username : root
- Mysql password : secret
- Database name : resto
- SSH host : 192.168.17.227
- SSH username : vagrant
- SSH password : vagrant

## H2 Serveur d'intégration

Travis : [https://travis-ci.org/joInMontreal/MGL7315-resto-presto](https://travis-ci.org/joInMontreal/MGL7315-resto-presto)
