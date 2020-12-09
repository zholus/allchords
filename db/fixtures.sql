-- pass "123123"
INSERT INTO accounts_users (id, email, password, username, access_token, access_token_expiry_at, created_at,
                                       refresh_token)
VALUES ('404f5d14-6d54-4759-aa5d-944ac70abd07', 'test1@gmail.com',
        '$2y$10$b0ezHw8NrxOxL2h4S6.gve842heoMIMDcfE88KMpWoqBWE0UXvmJu', 'username1', null, null, '2020-12-09 00:09:01',
        null);

INSERT INTO accounts_users_roles (user_id, role_id) VALUES ('404f5d14-6d54-4759-aa5d-944ac70abd07', 'e1d2dbe9-0147-4102-99e2-98e967c627d4');

INSERT INTO all_chords.comments_authors (id, username) VALUES ('404f5d14-6d54-4759-aa5d-944ac70abd07', 'username1');

INSERT INTO all_chords.comments_songs (id) VALUES ('05deca0a-6663-4173-a53f-220fa7159722');

INSERT INTO all_chords.songs_catalog_artists (id, title) VALUES ('696b4dd9-a959-4166-ab83-9f20297d3512', 'AC/DC');
INSERT INTO all_chords.songs_catalog_artists (id, title) VALUES ('9ee98f64-d20b-4607-b1b1-e12f6f69654a', 'Kino');
INSERT INTO all_chords.songs_catalog_artists (id, title) VALUES ('f45b6231-80a2-477a-9fac-7eede3b64e9f', 'Sektor gaza');

INSERT INTO all_chords.songs_catalog_creators (id, username) VALUES ('404f5d14-6d54-4759-aa5d-944ac70abd07', 'username1');

INSERT INTO all_chords.songs_catalog_genres (id, title) VALUES ('308d2f05-9591-4818-98d2-8bae884c7a34', 'Folk');
INSERT INTO all_chords.songs_catalog_genres (id, title) VALUES ('89a43c24-a819-4156-b40c-7177e61c9160', 'Metal');
INSERT INTO all_chords.songs_catalog_genres (id, title) VALUES ('661b7cb6-f682-4b13-9c62-1a8b03941eaa', 'Rock');

INSERT INTO all_chords.songs_catalog_songs (id, artist_id, genre_id, creator_id, title, chords, created_at) VALUES ('05deca0a-6663-4173-a53f-220fa7159722', '696b4dd9-a959-4166-ab83-9f20297d3512', '661b7cb6-f682-4b13-9c62-1a8b03941eaa', '404f5d14-6d54-4759-aa5d-944ac70abd07', 'title1', 'chords1', '2020-12-09 00:09:01');

INSERT INTO all_chords.songs_reviews_artists (id, title) VALUES ('696b4dd9-a959-4166-ab83-9f20297d3512', 'AC/DC');
INSERT INTO all_chords.songs_reviews_artists (id, title) VALUES ('9ee98f64-d20b-4607-b1b1-e12f6f69654a', 'Kino');
INSERT INTO all_chords.songs_reviews_artists (id, title) VALUES ('f45b6231-80a2-477a-9fac-7eede3b64e9f', 'Sektor gaza');

INSERT INTO all_chords.songs_reviews_creators (id, username) VALUES ('404f5d14-6d54-4759-aa5d-944ac70abd07', 'username1');

INSERT INTO all_chords.songs_reviews_genres (id, title) VALUES ('308d2f05-9591-4818-98d2-8bae884c7a34', 'Folk');
INSERT INTO all_chords.songs_reviews_genres (id, title) VALUES ('89a43c24-a819-4156-b40c-7177e61c9160', 'Metal');
INSERT INTO all_chords.songs_reviews_genres (id, title) VALUES ('661b7cb6-f682-4b13-9c62-1a8b03941eaa', 'Rock');