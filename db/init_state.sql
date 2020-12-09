-- accounts_permissions: table
CREATE TABLE `accounts_permissions`
(
    `id`   char(36) COLLATE utf8mb4_unicode_ci     NOT NULL,
    `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `UNIQ_name` (`name`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;

-- accounts_roles: table
CREATE TABLE `accounts_roles`
(
    `id`   char(36) COLLATE utf8mb4_unicode_ci     NOT NULL,
    `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `UNIQ_132F5FC05E237E06` (`name`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;

-- accounts_roles_permissions: table
CREATE TABLE `accounts_roles_permissions`
(
    `role_id`       char(36) COLLATE utf8mb4_unicode_ci     NOT NULL,
    `permission_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    PRIMARY KEY (`role_id`, `permission_id`),
    KEY `FK_permission` (`permission_id`),
    CONSTRAINT `FK_permission` FOREIGN KEY (`permission_id`) REFERENCES `accounts_permissions` (`id`),
    CONSTRAINT `FK_role` FOREIGN KEY (`role_id`) REFERENCES `accounts_roles` (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;

-- No native definition for element: FK_permission (index)

-- accounts_users: table
CREATE TABLE `accounts_users`
(
    `id`                     char(36) COLLATE utf8mb4_unicode_ci     NOT NULL,
    `email`                  varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `password`               varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `username`               varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `access_token`           varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `access_token_expiry_at` datetime                                DEFAULT NULL,
    `created_at`             datetime                                NOT NULL,
    `refresh_token`          varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `UNIQ_B192D4EEE7927C74` (`email`),
    UNIQUE KEY `UNIQ_B192D4EEF85E0677` (`username`),
    UNIQUE KEY `UNIQ_B192D4EEB6A2DD68` (`access_token`),
    UNIQUE KEY `UNIQ_B192D4EEC74F2195` (`refresh_token`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;

-- accounts_users_roles: table
CREATE TABLE `accounts_users_roles`
(
    `user_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
    `role_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
    PRIMARY KEY (`user_id`, `role_id`),
    KEY `IDX_BFE8DC38A76ED395` (`user_id`),
    KEY `IDX_BFE8DC38D60322AC` (`role_id`),
    CONSTRAINT `FK_BFE8DC38A76ED395` FOREIGN KEY (`user_id`) REFERENCES `accounts_users` (`id`),
    CONSTRAINT `FK_BFE8DC38D60322AC` FOREIGN KEY (`role_id`) REFERENCES `accounts_roles` (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;

-- No native definition for element: IDX_BFE8DC38A76ED395 (index)

-- No native definition for element: IDX_BFE8DC38D60322AC (index)

-- comments_authors: table
CREATE TABLE `comments_authors`
(
    `id`       char(36) COLLATE utf8mb4_unicode_ci     NOT NULL,
    `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `UNIQ_83C5D99DF85E0677` (`username`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;

-- comments_songs: table
CREATE TABLE `comments_songs`
(
    `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;

-- comments_songs_comments: table
CREATE TABLE `comments_songs_comments`
(
    `id`         char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
    `author_id`  char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `song_id`    char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `text`       longtext COLLATE utf8mb4_unicode_ci NOT NULL,
    `created_at` datetime                            NOT NULL,
    PRIMARY KEY (`id`),
    KEY `IDX_D247E9DFA0BDB2F3` (`song_id`),
    KEY `IDX_D247E9DFF675F31B` (`author_id`),
    CONSTRAINT `FK_D247E9DFA0BDB2F3` FOREIGN KEY (`song_id`) REFERENCES `comments_songs` (`id`),
    CONSTRAINT `FK_D247E9DFF675F31B` FOREIGN KEY (`author_id`) REFERENCES `comments_authors` (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;

-- No native definition for element: IDX_D247E9DFF675F31B (index)

-- No native definition for element: IDX_D247E9DFA0BDB2F3 (index)

-- doctrine_migration_versions: table
CREATE TABLE `doctrine_migration_versions`
(
    `version`        varchar(191) COLLATE utf8_unicode_ci NOT NULL,
    `executed_at`    datetime DEFAULT NULL,
    `execution_time` int      DEFAULT NULL,
    PRIMARY KEY (`version`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci;

-- songs_catalog_artists: table
CREATE TABLE `songs_catalog_artists`
(
    `id`    char(36) COLLATE utf8mb4_unicode_ci     NOT NULL,
    `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `UNIQ_7977B7732B36786B` (`title`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;

-- songs_catalog_creators: table
CREATE TABLE `songs_catalog_creators`
(
    `id`       char(36) COLLATE utf8mb4_unicode_ci     NOT NULL,
    `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `UNIQ_FC1B40D1F85E0677` (`username`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;

-- songs_catalog_genres: table
CREATE TABLE `songs_catalog_genres`
(
    `id`    char(36) COLLATE utf8mb4_unicode_ci     NOT NULL,
    `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `UNIQ_DD7D4CD2B36786B` (`title`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;

-- songs_catalog_songs: table
CREATE TABLE `songs_catalog_songs`
(
    `id`         char(36) COLLATE utf8mb4_unicode_ci     NOT NULL,
    `artist_id`  char(36) COLLATE utf8mb4_unicode_ci     NOT NULL,
    `genre_id`   char(36) COLLATE utf8mb4_unicode_ci     NOT NULL,
    `creator_id` char(36) COLLATE utf8mb4_unicode_ci     NOT NULL,
    `title`      varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `chords`     longtext COLLATE utf8mb4_unicode_ci     NOT NULL,
    `created_at` datetime                                NOT NULL,
    PRIMARY KEY (`id`),
    KEY `IDX_8C6801BC4296D31F` (`genre_id`),
    KEY `IDX_8C6801BC61220EA6` (`creator_id`),
    KEY `IDX_8C6801BCB7970CF8` (`artist_id`),
    CONSTRAINT `IDX_8C6801BC4296D31F` FOREIGN KEY (`genre_id`) REFERENCES `songs_catalog_genres` (`id`),
    CONSTRAINT `IDX_8C6801BC61220EA6` FOREIGN KEY (`creator_id`) REFERENCES `songs_catalog_creators` (`id`),
    CONSTRAINT `IDX_8C6801BCB7970CF8` FOREIGN KEY (`artist_id`) REFERENCES `songs_catalog_artists` (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;

-- No native definition for element: IDX_8C6801BCB7970CF8 (index)

-- No native definition for element: IDX_8C6801BC4296D31F (index)

-- No native definition for element: IDX_8C6801BC61220EA6 (index)

-- songs_reviews_artists: table
CREATE TABLE `songs_reviews_artists`
(
    `id`    char(36) COLLATE utf8mb4_unicode_ci     NOT NULL,
    `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `UNIQ_450A539E2B36786B` (`title`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;

-- songs_reviews_creators: table
CREATE TABLE `songs_reviews_creators`
(
    `id`       char(36) COLLATE utf8mb4_unicode_ci     NOT NULL,
    `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `UNIQ_229CA3F0F85E0677` (`username`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;

-- songs_reviews_genres: table
CREATE TABLE `songs_reviews_genres`
(
    `id`    char(36) COLLATE utf8mb4_unicode_ci     NOT NULL,
    `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `UNIQ_73D7E8E92B36786B` (`title`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;

-- songs_reviews_reviews: table
CREATE TABLE `songs_reviews_reviews`
(
    `id`         char(36) COLLATE utf8mb4_unicode_ci     NOT NULL,
    `creator_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `title`      varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `chords`     longtext COLLATE utf8mb4_unicode_ci     NOT NULL,
    `created_at` datetime                                NOT NULL,
    PRIMARY KEY (`id`),
    KEY `IDX_44A9388F61220EA6` (`creator_id`),
    CONSTRAINT `FK_44A9388F61220EA6` FOREIGN KEY (`creator_id`) REFERENCES `songs_reviews_creators` (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;

-- No native definition for element: IDX_44A9388F61220EA6 (index)

-- songs_reviews_reviews_artists: table
CREATE TABLE `songs_reviews_reviews_artists`
(
    `review_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
    `artist_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
    PRIMARY KEY (`review_id`, `artist_id`),
    KEY `IDX_9E6CA38F3E2E969B` (`review_id`),
    KEY `IDX_9E6CA38FB7970CF8` (`artist_id`),
    CONSTRAINT `FK_9E6CA38F3E2E969B` FOREIGN KEY (`review_id`) REFERENCES `songs_reviews_reviews` (`id`),
    CONSTRAINT `FK_9E6CA38FB7970CF8` FOREIGN KEY (`artist_id`) REFERENCES `songs_reviews_artists` (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;

-- No native definition for element: IDX_9E6CA38F3E2E969B (index)

-- No native definition for element: IDX_9E6CA38FB7970CF8 (index)

-- songs_reviews_reviews_genres: table
CREATE TABLE `songs_reviews_reviews_genres`
(
    `review_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
    `genre_id`  char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
    PRIMARY KEY (`review_id`, `genre_id`),
    KEY `IDX_AEEE2FC33E2E969B` (`review_id`),
    KEY `IDX_AEEE2FC34296D31F` (`genre_id`),
    CONSTRAINT `FK_AEEE2FC33E2E969B` FOREIGN KEY (`review_id`) REFERENCES `songs_reviews_reviews` (`id`),
    CONSTRAINT `FK_AEEE2FC34296D31F` FOREIGN KEY (`genre_id`) REFERENCES `songs_reviews_genres` (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;

-- No native definition for element: IDX_AEEE2FC33E2E969B (index)

-- No native definition for element: IDX_AEEE2FC34296D31F (index)

-- data

INSERT INTO accounts_permissions (id, name)
VALUES ('c31933cd-931f-4c44-847a-004b666b1a20', 'CAN_REVIEW_SONGS');

INSERT INTO accounts_roles (id, name)
VALUES ('e1d2dbe9-0147-4102-99e2-98e967c627d4', 'Moderator');

INSERT INTO accounts_roles_permissions (role_id, permission_id)
VALUES ('e1d2dbe9-0147-4102-99e2-98e967c627d4', 'c31933cd-931f-4c44-847a-004b666b1a20');