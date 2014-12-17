# Kurulum

## Bağımlılıkların İndirilmesi
Bağımlılıklar composer ile sağlanmaktadır. Aşağıdaki komutla bağımlı kütüphaneler indirilebilir:

```bash
$ cd <project-root>
$ composer update
```

## Ortam Ayarları
Ortama bağlı özel ayar dosyası oluşturulmalıdır. Bu işlemi için *configs/env/ortamadi.php* şeklinde ayar dosyası
oluşturulmalı ve ortama bağlı değişen ayarlar global.php dosyasından alınıp bu dosyaya aktarılmalıdır. Örnek için
*configs/env/development.php.sample* dosyasına bakılabilir.

Ortam adı *APPLICATION_ENV* değeri ile belirtilir. Konsolda veya web sunucusu ayarlarında bu değer tanımlanmalıdır.

## Veritabanı
Veritabanı değişiklikleri için doctrine/migrations kütüphanesi kullanılmaktadır. Veritabanı versiyonunu en son sürüme
çekmek için aşağıdaki komut çalıştırılmalıdır.

```bash
$ cd <project-root>
$ php bin/console.php migrations:migrate
```

Yeni bir versiyon tanımlamak için şu komut çalıştırılır:

```bash
$ cd <project-root>
$ php bin/console.php migrations:generate
```

Yeni sürüm veritabanına yansıtılmadan önce aşağıdaki komutla değişiklikler görülebilir:
```bash
$ cd <project-root>
$ pbp bin/console.php migrations:migrate --dry-run
```