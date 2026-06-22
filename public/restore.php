<?php
chdir('..');
echo shell_exec('git restore app/Controllers/ServiceController.php app/Config/Routes.php app/Views/user/dashboard.php app/Views/user/services/book_delivery.php app/Views/user/services/room_booking.php app/Views/user/services/referensi.php app/Views/user/services/sitasi.php app/Views/user/services/mendeley_class.php app/Views/user/services/konsultasi.php app/Views/user/services/language_class.php');
echo "Restored!";
