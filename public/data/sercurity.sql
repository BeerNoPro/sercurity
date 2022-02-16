CREATE TABLE `company` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(255),
  `address` varchar(100),
  `phone_number` int(15),
  `email` varchar(50),
  `date_incorporation` date
);

CREATE TABLE `work_room` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(100),
  `location` varchar(255),
  `created_at` datetime,
  `updated_at` datetime
);

CREATE TABLE `member` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(100),
  `email` varchar(50),
  `password` varchar(50),
  `address` varchar(255),
  `phone_number` varchar(100),
  `work_position` varchar(50),
  `date_join_company` datetime,
  `date_left_company` datetime,
  `company_id` int,
  `created_at` datetime,
  `updated_at` datetime
);
ALTER TABLE `member` ADD FOREIGN KEY (`company_id`) REFERENCES `company` (`id`);

CREATE TABLE `project` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(255),
  `time_start` datetime,
  `time_completed` datetime,
  `company_id` int,
  `work_room_id` int,
  `created_at` datetime,
  `updated_at` datetime
);
ALTER TABLE `project` ADD FOREIGN KEY (`company_id`) REFERENCES `company` (`id`);
ALTER TABLE `project` ADD FOREIGN KEY (`work_room_id`) REFERENCES `work_room` (`id`);

CREATE TABLE `member_project` (
  `project_id` int NOT NULL,
  `member_id` int NOT NULL,
  `role` varchar(20),
  `time_member_join` varchar(20),
  `time_member_complted` varchar(20),
  `created_at` datetime,
  `updated_at` datetime
);
ALTER TABLE `member_project` ADD CONSTRAINT `pk_member_project` PRIMARY KEY (`project_id`, `member_id`);
ALTER TABLE `member_project` ADD FOREIGN KEY (`member_id`) REFERENCES `member` (`id`);
ALTER TABLE `member_project` ADD FOREIGN KEY (`project_id`) REFERENCES `project` (`id`);

CREATE TABLE `training` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `trainer` int,
  `content` text(200),
  `project_id` int,
  `created_at` datetime,
  `updated_at` datetime
);
ALTER TABLE `training` ADD FOREIGN KEY (`trainer`) REFERENCES `member` (`id`);
ALTER TABLE `training` ADD FOREIGN KEY (`project_id`) REFERENCES `project` (`id`);

CREATE TABLE `training_room` (
  `training_id` int NOT NULL,
  `member_id` int NOT NULL,
  `date_start` datetime,
  `date_completed` datetime,
  `result` varchar(20),
  `note` text(500)
);
ALTER TABLE `training_room` ADD CONSTRAINT `pk_training_room` PRIMARY KEY (`training_id`, `member_id`);
ALTER TABLE `training_room` ADD FOREIGN KEY (`training_id`) REFERENCES `training` (`id`);
ALTER TABLE `training_room` ADD FOREIGN KEY (`member_id`) REFERENCES `member` (`id`);

CREATE TABLE `device` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `ip_address` varchar(20),
  `ip_mac` varchar(20),
  `user_login` varchar(100),
  `version_win` varchar(20),
  `version_virus` varchar(20),
  `update_win` datetime,
  `member_id` int,
  `created_at` datetime,
  `updated_at` datetime
);
ALTER TABLE `device` ADD FOREIGN KEY (`member_id`) REFERENCES `member` (`id`);

CREATE TABLE `carbinet` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(255),
  `work_room_id` int,
  `member_id` int,
  `created_at` datetime,
  `updated_at` datetime
);
ALTER TABLE `carbinet` ADD FOREIGN KEY (`work_room_id`) REFERENCES `work_room` (`id`);
ALTER TABLE `carbinet` ADD FOREIGN KEY (`member_id`) REFERENCES `member` (`id`);


