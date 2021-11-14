DROP TABLE photo_gallery;
CREATE TABLE photo_gallery (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  title CHAR(100) NOT NULL,
  caption TINYTEXT,
  alt CHAR(100) NOT NULL,
  img_name TINYTEXT NOT NULL
);
INSERT INTO photo_gallery (title, caption, alt, img_name)
VALUES (
    'Awesome picture 1.0',
    'Really awesome picture with some really awesome caption!',
    'awesome_picture_1_0',
    'awesome-picture-1-0.jpg'
  );
INSERT INTO photo_gallery (title, caption, alt, img_name)
VALUES (
    'Awesome picture 1.1',
    'Really awesome picture with some really awesome caption!',
    'awesome_picture_1_1',
    'awesome-picture-1-1.jpg'
  );
INSERT INTO photo_gallery (title, caption, alt, img_name)
VALUES (
    'Awesome picture 1.2',
    'Really awesome picture with some really awesome caption!',
    'awesome_picture_1_2',
    'awesome-picture-1-2.jpg'
  );
INSERT INTO photo_gallery (title, caption, alt, img_name)
VALUES (
    'Awesome picture 1.3',
    'Really awesome picture with some really awesome caption!',
    'awesome_picture_1_3',
    'awesome-picture-1-3.jpg'
  );
INSERT INTO photo_gallery (title, caption, alt, img_name)
VALUES (
    'Awesome picture 2.0',
    'Really awesome picture with some really awesome caption!',
    'awesome_picture_2_0',
    'awesome-picture-2-0.jpg'
  );
INSERT INTO photo_gallery (title, caption, alt, img_name)
VALUES (
    'Awesome picture 2.1',
    'Really awesome picture with some really awesome caption!',
    'awesome_picture_2_1',
    'awesome-picture-2-1.jpg'
  );
INSERT INTO photo_gallery (title, caption, alt, img_name)
VALUES (
    'Awesome picture 2.2',
    'Really awesome picture with some really awesome caption!',
    'awesome_picture_2_2',
    'awesome-picture-2-2.jpg'
  );
INSERT INTO photo_gallery (title, caption, alt, img_name)
VALUES (
    'Awesome picture 2.3',
    'Really awesome picture with some really awesome caption!',
    'awesome_picture_2_3',
    'awesome-picture-2-3.jpg'
  );