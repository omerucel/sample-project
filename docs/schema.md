# doctrine_migration

Doctrine migrations versiyonlarını tutar. Silinmemesi gerekir.

# role

Kullanıcı rollerini tutar.

- id
- name

# permission

Kullanıcı izinlerini tutar.

- id
- permission

# role_permission

Rollere bağlı izinleri tutar.

- id
- role_id
- permission_id

# user

Kullanıcıları tutar.

- id
- role_id : Kullanıcı rolü
- email : Tekil olmalı.
- password : password_hash ile PASSWORD_BCRYPT yöntemi ile şifre üretilmeli.
- name
- surname

# user_phone

Kullanıcı telefonlarını tutar.

- id
- user_id
- phone
- type: mobile, home, work
- extension_number

# user_address

Kullanıcı adres bilgilerini tutar.

- id
- user_id
- name
- country
- city
- address
- phone
- extension_number
