## Turkish version is below the English version...




## Flalingo Task - Laravel React Admin Extension _ OKAN SEN
This project adds a Task Management Module to the Laravel React Admin panel. It enables users to create, edit, and track tasks. Additionally, tasks can start automatically based on their scheduled time, with support for smart status progression.

## Features
- Create, update, delete tasks

- Assign start time to tasks

- Queue-based automatic task starting (via Laravel Jobs)

- Notifications to users on task status change (email-based)

- Smart task lifecycle:
Pending → In Progress → Needs Revision → Completed

- Drag & Drop Kanban board

- Fixes N+1 query issues via eager loading

- Mail notifications using Laravel Notifications and Google SMTP

## API Endpoints
Endpoint	            Method	        Description
/api/tasks	            GET	            List all tasks
/api/tasks	            POST	        Create new task
/api/tasks/{id}	        GET	            Get a specific task
/api/tasks/{id}	        PUT	            Update a task
/api/tasks/{id}	        DELETE	        Delete a task


## Known Issues / Missing Features
- Tasks cannot have multiple assigned users yet (only one user supported, also the user assignment must be manually done through the database dashboard such as phpmyadmin).

- No user-specific filtering — all tasks are globally listed.

- No role-based task deletion restrictions — anyone can delete for now.

- No Swagger/Postman API documentation.

- Statuses are currently hardcoded in some areas (no centralized config).

- No advanced frontend optimization (e.g., React memoization).

- Drag-and-drop may behave unexpectedly because task order is based on task ID, not custom order.

## Status Flow Logic
Tasks move through these states automatically when their start_time is reached:

Pending → In Progress → Needs Revision → Completed

## Setup Guide
1. Clone the Repo

git clone https://github.com/OkanSen/Laravel_React_Project_OkanSen.git
cd laravel-react-admin


2. Install Dependencies
Laravel backend:

composer install


React frontend:

npm install


3. Environment Setup

cp .env.example .env
php artisan key:generate
Edit .env to match your DB configuration.

4. Database Migrations & Seeding

php artisan migrate
php artisan db:seed

After running StatusesSeeder, you'll have the following default statuses: Pending, In Progress, Needs Revision, Completed

5. Build Frontend

npm run dev
# or
npm run production


6. Queue Worker & Smart Scheduler
Start the queue worker:

php artisan queue:work


Dispatch smart tasks manually:

php artisan job:dispatch-smart
Run smart dispatcher every minute (optional):

while true; do php artisan job:dispatch-smart; sleep 60; done











# Flalingo Task - Laravel React Admin Extension _ OKAN SEN

Bu proje, Laravel React Admin paneline bir "Görev Yönetimi Modülü" eklemek amacıyla geliştirilmiştir. Kullanıcıların görev oluşturabileceği, düzenleyebileceği ve takip edebileceği bir yapı sunar. Ek olarak görevlerin başlangıç zamanına göre otomatik başlatılması ve statü geçişleri desteklenmektedir.

---

## Özellikler

- Görev oluşturma, düzenleme, silme
- Görevlere başlangıç zamanı atayabilme
- Queue job sistemi ile zamanında görev başlatma
- Görev statüsü değişiminde anlık bildirim gönderimi(Laravel Notifications & Automated Mail)
- Akıllı görev yönetimi (statü geçişleri: Pending → In Progress → Needs Revision → Completed)
- Drag & Drop destekli Kanban Board
- Eager Loading ile N+1 problemi çözümü
- Laravel Notifications ile kullanıcıya mail gönderimi

---

## Kurulum ve Kullanım
Aşağıda detaylı açıklama var...

### Queue Worker Başlatma:
php artisan queue:work
php artisan job:dispatch-smart (bu one-shot usage için)
while true; do php artisan job:dispatch-smart; sleep 60; done (sürekli looplaması için bu kullanılabilir)

## API Endpoint'leri
Endpoint		    Method		Açıklama
/api/tasks		    GET		    Tüm görevleri listeler
/api/tasks		    POST		Yeni görev oluşturur
/api/tasks/{id}		GET		    Belirli görevi getirir
/api/tasks/{id}		PUT		    Görevi günceller
/api/tasks/{id}		DELETE		Görevi siler

## Bilinen Sorunlar ve Eksiklikler
 Task'lere atanan kişi (user) çoklu seçilemiyor. Frontend'de sadece tek kullanıcı için alan mevcut - bu da şimdilik sadece database dashboard'dan yapılabiliyor.

 Kullanıcı bazlı görev filtrelemesi yok. Dashboard tüm görevleri listeliyor.

 Görev silme sadece owner'lara kısıtlanmadı (şimdilik herkes silebilir).

 API dokümantasyonu Postman veya Swagger formatında hazırlanmadı.

 Görev statüleri sabit bir yerden çekilmiyor şu anda, back-end ve front-ende düzenleme gerektirdiğinden bazı yerlerde hardcoded statü tipleri.

 Memoization gibi ileri seviye frontend optimizasyonları uygulanmadı.

Task Dashboard üzerinde şimdilik bütün task'ler id'leri üzerinden sıralandığı için darg and drop'tan sonra ilginç düzenlemeler görülebilir. Id bazlı sıralamadan dolayı gerçekleşiyor bunlar (örneğin: task sıralarının drag and droplandığı sütunun içinde sırasını değiştirmesi, sütun sıralarının deişmesi gibi)



## Statü Geçiş Sistemi
Görevler aşağıdaki sırayla otomatik güncellenir:

Pending → In Progress → Needs Revision → Completed



## Ek Bilgiler
Branch: feature/flaling-task

Laravel Versiyon: 6.20.45

Node Version: >=12.x önerilir

Task modülü full responsive ve React Kanban board tabanlıdır.

## Geliştirici Notları
Bu projede zaman kısıtlı olduğundan dolayı bazı özellikler temel seviyede bırakıldı, ancak sistem genişletilmeye uygun olarak yapılandırıldı. İleride rollere göre yetkilendirme, kullanıcı bazlı görev gösterimi ve görev geçmişi gibi alanlar kolayca eklenebilir.

## Kurulum
Aşağıdaki adımlar, projeyi yerel ortamınızda çalıştırmak için gereklidir:

1. Reponun Klonlanması

git clone https://github.com/OkanSen/Laravel_React_Project_OkanSen.git
cd laravel-react-admin


2. Gerekli Paketlerin Kurulumu
Backend (Laravel) için:

composer install


Frontend (React) için:

npm install



3. .env Dosyasının Oluşturulması

cp .env.example .env
php artisan key:generate


.env dosyasında veritabanı bağlantısı gibi bilgileri doldurmayı unutmayın.

4. Veritabanı Migrasyon ve Seed

php artisan migrate
php artisan db:seed


StatusesSeeder çalıştıktan sonra varsayılan statüler: Pending, In Progress, Needs Revision, Completed

5. Frontend Derleme

npm run dev


# veya prod ortamı için
npm run production


6. Queue Worker ve Zamanlayıcı Başlatma
Queue worker'ı başlat:

php artisan queue:work



Akıllı görev zamanlayıcısını çalıştır (manuel):

php artisan job:dispatch-smart


Otomatik olarak her dakika çalıştırmak için (opsiyonel):

while true; do php artisan job:dispatch-smart; sleep 60; done
