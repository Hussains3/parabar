CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@app.com', NULL, '$2y$10$H5kCwDKMY4p18LovaENz2.SsRLoJFxbGE/drTR1hIGGf1MStwhLYq', 'l9s3NfmuXAKglF9deN5h53RqgvdeWlE3oKHkNcUbiKCxyc6JHiGfVj82Dqxi', '2020-12-24 00:27:03', '2020-12-24 00:27:03'),
(2, 'Receiver', 'receiver@app.com', NULL, '$2y$10$tVxFdrMhKZ0nChW2tL0z/.fcNblf0GnXRMmJqitAAfnnW5ImG9B9a', '4rYNVC6NljNfrBRUPZOhM13M0HZcnAXOHMWp6fxdpT93jriYQzgvI2PKcq4p', '2020-12-24 00:27:03', '2020-12-24 00:27:03'),
(3, 'Operator', 'operator@app.com', NULL, '$2y$10$d02MyELMoRqa8GYGG4WKEuEe3L/Nd/1FeEVbkK5mVp4nQ4.v2Sb.W', '5YIPQbGW8ZUveUG28D5rrcs06PHk0DrJ3YHxVriUApvhMXE5pOGfmBni7VFa', '2020-12-24 00:27:03', '2020-12-24 00:27:03'),
(4, 'Deliver', 'deliver@app.com', NULL, '$2y$10$oqnvaBYzamTDHTU.v.xud.pmTtZ4xSHs1a9Fe8bZ5h5mYEmyj5Cwm', 'Ct9IOx06b75YYrbneduSVkhZtclifU3FgWtftKhp4SLPSwUxZj7qopAgO1Yj', '2020-12-24 00:27:03', '2020-12-24 00:27:03'),
(15, 'MD.RASHADUR  RAHMAN RIAD', 'reyad.bpl@gmail.com', NULL, '$2y$10$I7sEoQ2M3Giz4wAK096kweRxTYEmTh0wDA4FDDTQBcY8GsQVDKtI2', 'c3N51EHuajW0pw4GaUxCqzcao6bL2UIprj9Kdc2MTx0e75OGWqh8W3oKOBsH', '2020-12-26 06:52:02', '2020-12-26 06:52:02'),
(16, 'SHU-MOHON BISWAS', 's.mohon108@gmail.com', NULL, '$2y$10$16qbCLl6KklmBhR.j5iTw.PE8ACehxJoAxMYFbcUsaLCXLQ3bBuV2', 'ivLuGsgs1Se1MOYM3pTsa1eHi0JDGqnfadTzXP69m0NRvGqBr7cDeqhpYHEF', '2020-12-26 06:53:31', '2020-12-26 06:53:31'),
(17, 'IMON HOSSAIN', 'imondti2014@gmail.com', NULL, '$2y$10$c1VJd3mzOGXXZfdAvgaL.ubHphxBx/XOUYHx.anRreuY2e1OYcLUC', '1qQC8L8hG9FsNveOTBPGSwNW0I8OQsgq04tIjpRZIuIXtSJmHkqioBtxres3', '2020-12-26 06:56:02', '2020-12-26 06:56:02'),
(18, 'MD. HABIBUR RAHMAN', 'habibdti@gmail.com', NULL, '$2y$10$zwA15b5FZtLmWVTUMIc9n.1vanmEAk4/Kpgtea2u9scXpQfSomKea', 'JSQlPpJcj8UbasGMoEplxaMCvKGLgfUwxMH6TPO2dn1vl1y2QfCN3wwowhIK', '2020-12-26 07:01:43', '2020-12-26 07:01:43'),
(19, 'FARHANA YESMEEN  HIRA', 'farhanahira.bpl@gmail.com', NULL, '$2y$10$r9BOmCEX41Y/6iM.syK9Q..biPwEAamQY/2BkVizeW9Uie/l5poNG', 'rYs9bU8GUvqGYPA6acMjgT983rWIeIzWHWkbRsLJCGJ0ucKS91ugk3QJEkUW', '2020-12-26 08:29:08', '2020-12-26 08:29:08'),
(20, 'ABDULLAH AL MAMUN SHUVO', 'shuvodti@gmail.com', NULL, '$2y$10$mg.lu8Tk/Hw77aMz2xECruVtsJR1e3ZdbNKBakbsY2AC.3c2JPuSy', 'ocbqWKCkXcATQp4PXkVSMqxjs2OJEUzqwVBATB1zq6OzYlyDMyxzUCQOpoBH', '2020-12-26 08:38:45', '2020-12-31 05:14:27'),
(21, 'SHEAK FAYSAL UDDIN', 'faysaldti@gmail.com', NULL, '$2y$10$0M3Z.KRTtcxd9hK0Ilu6KOY.38TQmpsjI0OE30RA3fL.vy66WHwCC', 'LqtCKtwthDupr29GXf4igTBUXIoOQIzKfWEqKQSRj16c5k6bCju1S21hey0x', '2020-12-26 08:39:58', '2020-12-26 08:39:58'),
(22, 'Raju Ahmed', 'associationbpl@gmail.com', NULL, '$2y$10$r7ud91K0xL.F/zAf4ApIAeALIkg2sBddLhveR4y9OFf0UvNN7zq4y', 'mHQbmRlAaY5h0usYaVLHZv4bAnHJBsO8GInUGQxKSa1QGtls9fhpRftbgXYD', '2020-12-26 12:57:38', '2020-12-26 12:57:38'),
(23, 'Muntasir al mamun', 'muntasiralmamun@gmail.com', NULL, '$2y$10$Kp4DzDNwvcWZXRuj6QrOwOV.sVrO1WJKNBS99VdgjgVAvSAOBf1o2', 'Rz3ZwAyFck5QFF45sAm6WYRtYNhUwL14EN3JayCedksU7io0ixPfJ7l9M5aN', '2020-12-27 06:14:32', '2020-12-27 06:14:32'),
(24, 'Muntasir al mamun D', 'ashaud14octa@gmail.com', NULL, '$2y$10$AnHvrhYqjl7RGFbO904bO.fsHOIQQGZLBFTPJJzzWK9xsyedJcT66', 'p6yhrheOzQg9JEV4pEU7p1iyVxBDApNZPWT8jxH2iEvENj3RaryctnlLvcTN', '2020-12-27 06:25:27', '2020-12-27 06:25:27'),
(25, 'Extra Account', 'dtibranch@gmail.com', NULL, '$2y$10$Qzbrk83EJY7YLQDUihHjxerTNWOYaTxEWXGblEyD7QUNWAIJcSnuK', 'AJzNdmHPYHleLGBTeTPBz9vbLUF9HQehDkCUplyXO2LYG1iYEoTwNKpEQEpt', '2021-01-26 10:59:08', '2021-01-26 10:59:08'),
(26, 'dadadsdasd', '4323@mail.com', NULL, '$2y$10$wMXgNlbnCOdEZdYQYZIGvOAnLXqW4/EvEfgTgh0wzs9I.tJeBfkoq', NULL, '2023-04-30 17:25:47', '2023-04-30 17:25:47');
