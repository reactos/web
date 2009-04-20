

-- -----------------------------------------------------------------
-- Drop obsolete tables
-- -----------------------------------------------------------------
DROP TABLE rsdb_item_devnet;
DROP TABLE rsdb_item_pack;
DROP TABLE rsdb_urls;
DROP TABLE _rsdb_users;
DROP TABLE rsdb_stats;
DROP TABLE rsdb_object_osversions; -- needs a manual convert to tag specific revisions
DROP TABLE _rsdb_item_comp_votes;
DROP TABLE rsdb_object_description;
DROP TABLE rsdb_group_bundles;



-- -----------------------------------------------------------------
-- Convert categories
-- -----------------------------------------------------------------
CREATE TABLE cdb_categories (
  id BIGINT UNSIGNED NOT NULL ,
  parent BIGINT UNSIGNED NULL COMMENT '->categories(id)',
  name VARCHAR( 100 ) NOT NULL ,
  description VARCHAR( 255 ) NOT NULL ,
  icon VARCHAR( 100 ) NULL ,
  visible BOOL NOT NULL DEFAULT FALSE,
  PRIMARY KEY ( id )
) ENGINE = MYISAM;

INSERT INTO cdb_categories
  SELECT
    cat_id,
    cat_path,
    cat_name,
    cat_description,
    cat_icon,
    TRUE
  FROM rsdb_categories
  WHERE cat_visible = '1'
UNION
  SELECT
    cat_id,
    cat_path,
    cat_name,
    cat_description,
    cat_icon,
    FALSE
  FROM rsdb_categories
  WHERE cat_visible = '0';

ALTER TABLE cdb_categories ORDER BY id;
DROP TABLE rsdb_categories;


-- -----------------------------------------------------------------
-- Convert comments
-- -----------------------------------------------------------------
CREATE TABLE cdb_comments (
  id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
  entry_id BIGINT UNSIGNED NULL COMMENT '->entries(id)',
  parent BIGINT UNSIGNED NULL COMMENT '->comments(id)',
  user_id BIGINT UNSIGNED NOT NULL COMMENT '->roscms.accounts(id)',
  title VARCHAR( 100 ) NOT NULL ,
  content TEXT NOT NULL ,
  creation DATETIME NOT NULL ,
  visible BOOL NOT NULL DEFAULT FALSE
) ENGINE = MYISAM COMMENT = 'parent xor entry_id has to be NULL';

INSERT INTO cdb_comments
  SELECT
    fmsg_id,
    NULL,
    fmsg_parent,
    fmsg_user_id,
    fmsg_subject,
    fmsg_body,
    fmsg_date,
    TRUE
  FROM rsdb_item_comp_forum
  WHERE fmsg_visible='1' AND fmsg_parent > 0
UNION
  SELECT
    fmsg_id,
    NULL,
    fmsg_parent,
    fmsg_user_id,
    fmsg_subject,
    fmsg_body,
    fmsg_date,
    FALSE
  FROM rsdb_item_comp_forum
  WHERE fmsg_visible='0' AND fmsg_parent > 0
UNION
  SELECT
    fmsg_id,
    fmsg_comp_id,
    NULL,
    fmsg_user_id,
    fmsg_subject,
    fmsg_body,
    fmsg_date,
    TRUE
  FROM rsdb_item_comp_forum
  WHERE fmsg_visible='1' AND fmsg_parent = 0
UNION
  SELECT
    fmsg_id,
    fmsg_comp_id,
    NULL,
    fmsg_user_id,
    fmsg_subject,
    fmsg_body,
    fmsg_date,
    FALSE
  FROM rsdb_item_comp_forum
  WHERE fmsg_visible='0' AND fmsg_parent = 0;

ALTER TABLE cdb_comments ORDER BY id;
DROP TABLE rsdb_item_comp_forum;


INSERT INTO cdb_comments
SELECT
  NULL,
  test_comp_id,
  NULL,
  test_user_id,
  'Test report',
  CONCAT(test_user_comment,'


>>> What works: 
',test_whatworks,'

>>> What doesn''t work
',test_whatdoesntwork,'

>>> What I''ve not tested
',test_whatnottested,'

>>> Conclusion
',test_conclusion),
  test_date,
  TRUE
FROM rsdb_item_comp_testresults;
DROP TABLE rsdb_item_comp_testresults;




-- -----------------------------------------------------------------
-- Convert attachements
-- -----------------------------------------------------------------
CREATE TABLE cdb_attachments (
  id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
  entry_id BIGINT UNSIGNED NOT NULL COMMENT '->entry(id)',
  user_id BIGINT UNSIGNED NOT NULL COMMENT '->roscms.users(id)',
  file VARCHAR( 250 ) NOT NULL ,
  type VARCHAR( 100 ) NOT NULL COMMENT 'content type',
  description TEXT NOT NULL ,
  created DATETIME NOT NULL ,
  visible BOOL NOT NULL DEFAULT FALSE
) ENGINE = MYISAM;

INSERT INTO cdb_attachments
  SELECT
    media_id,
    media_groupid,
    media_user_id,
    media_file,
    media_filetype,
    media_description,
    media_date,
    TRUE
  FROM rsdb_object_media
  WHERE media_visible = '1'
UNION
  SELECT
    media_id,
    media_groupid,
    media_user_id,
    media_file,
    media_filetype,
    media_description,
    media_date,
    FALSE
  FROM rsdb_object_media
  WHERE media_visible = '0';

ALTER TABLE cdb_attachments ORDER BY id;
DROP TABLE rsdb_object_media;




-- -----------------------------------------------------------------
-- Convert languages
-- -----------------------------------------------------------------
CREATE TABLE cdb_languages (
  id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
  name VARCHAR( 50 ) NOT NULL ,
  short VARCHAR( 5 ) NOT NULL ,
  original VARCHAR( 50 ) NOT NULL
) ENGINE = MYISAM;

INSERT INTO cdb_languages
SELECT
  NULL,
  lang_name,
  lang_id,
  ''
FROM rsdb_languages;

DROP TABLE rsdb_languages;



-- -----------------------------------------------------------------
-- Convert entries reports
-- -----------------------------------------------------------------
CREATE TABLE cdb_entries_reports (
  id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  entry_id BIGINT UNSIGNED NOT NULL COMMENT '->entries(id)',
  revision BIGINT UNSIGNED NOT NULL,
  old_name VARCHAR( 100 ) NOT NULL,
  old_version VARCHAR( 100 ) NOT NULL,
  old_description TEXT NOT NULL,
  user_id BIGINT UNSIGNED NOT NULL COMMENT '->roscms.users(id)',
  works BOOL DEFAULT FALSE,
  checked BOOL NOT NULL DEFAULT FALSE,
  created DATETIME NOT NULL,
  visible BOOL NOT NULL DEFAULT FALSE,
  disabled BOOL NOT NULL DEFAULT TRUE,
  old_groupid BIGINT NOT NULL DEFAULT '0',
  old_osversion VARCHAR( 6 ) NOT NULL DEFAULT '000000'
) ENGINE = MyISAM;

INSERT INTO cdb_entries_reports
SELECT DISTINCT
  comp_id,
  0,
  0,
  comp_name,
  comp_appversion,
  comp_description,
  comp_usrid,
  NULL,
  FALSE,
  comp_date,
  TRUE,
  FALSE,
  comp_groupid,
  comp_osversion
FROM rsdb_item_comp
WHERE comp_date != '0000-00-00 00:00:00';




-- -----------------------------------------------------------------
-- Convert entries
-- -----------------------------------------------------------------
CREATE TABLE cdb_entries (
  id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR( 100 ) NOT NULL,
  version VARCHAR( 100 ) NOT NULL,
  description TEXT NOT NULL,
  created DATETIME NOT NULL,
  modified DATETIME NOT NULL,
  visible BOOL NOT NULL DEFAULT FALSE,
  old_groupid BIGINT NOT NULL DEFAULT '0',
  old_vendorid BIGINT NOT NULL DEFAULT '0',
  UNIQUE KEY(name, version)
) ENGINE = MyISAM;

INSERT INTO cdb_entries
SELECT DISTINCT
  NULL,
  old_name,
  old_version,
  old_description,
  created,
  modified,
  TRUE,
  old_groupid,
  grpentr_vendor
FROM (
  SELECT DISTINCT
    o.old_name,
    o.old_version,
    (SELECT i.old_description FROM cdb_entries_reports i WHERE i.old_name=o.old_name AND i.old_version=o.old_version ORDER BY i.created ASC LIMIT 1) AS old_description,
    (SELECT i.created FROM cdb_entries_reports i WHERE i.old_name=o.old_name AND i.old_version=o.old_version ORDER BY i.created ASC LIMIT 1) AS created,
    (SELECT i.created FROM cdb_entries_reports i WHERE i.old_name=o.old_name AND i.old_version=o.old_version ORDER BY i.created DESC LIMIT 1) AS modified,
    o.old_groupid,
    g.grpentr_vendor
  FROM cdb_entries_reports o
  JOIN rsdb_groups g ON g.grpentr_id=o.old_groupid) k;

UPDATE cdb_entries_reports r
SET entry_id = (SELECT e.id FROM cdb_entries e WHERE r.old_name=e.name LIMIT 1);

ALTER TABLE cdb_entries_reports
  DROP old_name,
  DROP old_description,
  DROP old_groupid;

DROP TABLE rsdb_item_comp;



-- -----------------------------------------------------------------
-- Convert tags
-- -----------------------------------------------------------------
CREATE TABLE cdb_tags (
  id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
  category_id BIGINT COMMENT '->categories(id)',
  name VARCHAR( 100 ) NOT NULL ,
  description TEXT NOT NULL ,
  user_id BIGINT UNSIGNED NOT NULL COMMENT '->roscms.users(id)',
  created DATETIME NOT NULL ,
  visible BOOL NOT NULL DEFAULT FALSE ,
  disabled BOOL NOT NULL DEFAULT TRUE ,
  old_vendor BIGINT,
  old_groupid BIGINT
) ENGINE = MYISAM;

-- groups
INSERT INTO cdb_tags
SELECT DISTINCT
  NULL,
  (SELECT grpentr_category FROM rsdb_groups WHERE grpentr_name=g.grpentr_name ORDER BY grpentr_date DESC LIMIT 1),
  grpentr_name,
  grpentr_description,
  grpentr_usrid,
  (SELECT grpentr_date FROM rsdb_groups WHERE grpentr_name=g.grpentr_name ORDER BY grpentr_date DESC LIMIT 1),
  TRUE,
  FALSE,
  (SELECT grpentr_vendor FROM rsdb_groups WHERE grpentr_name=g.grpentr_name ORDER BY grpentr_date DESC LIMIT 1),
  grpentr_id
FROM rsdb_groups g
WHERE grpentr_comp = '1' AND grpentr_visible = '1';

-- vendors
INSERT INTO cdb_tags
SELECT DISTINCT
  NULL,
  NULL,
  vendor_name,
  CONCAT(vendor_fullname,'

Website: ',vendor_url),
  vendor_usrid,
  vendor_date,
  TRUE,
  FALSE,
  vendor_id,
  NULL
FROM rsdb_item_vendor;

DROP TABLE rsdb_groups;
DROP TABLE rsdb_item_vendor;



-- -----------------------------------------------------------------
-- Convert logs
-- -----------------------------------------------------------------
CREATE TABLE cdb_logs (
  id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
  user_id BIGINT UNSIGNED NOT NULL COMMENT '->roscms.users(id)',
  content TEXT NOT NULL ,
  creation DATETIME NOT NULL
) ENGINE = MYISAM;

INSERT INTO cdb_logs
SELECT
  log_id,
  log_usrid,
  CONCAT(log_title,'

',log_description),
  log_date
FROM rsdb_logs;

DROP TABLE rsdb_logs;



-- -----------------------------------------------------------------
-- Convert tag assignments
-- -----------------------------------------------------------------
CREATE TABLE cdb_rel_entries_tags (
  entry_id BIGINT UNSIGNED NOT NULL COMMENT '->entries(id)',
  tag_id BIGINT UNSIGNED NOT NULL COMMENT '->tags(id)',
  PRIMARY KEY ( entry_id , tag_id )
) ENGINE = MYISAM;

INSERT INTO cdb_rel_entries_tags
SELECT
  e.id,
  t.id
FROM cdb_entries e
JOIN cdb_tags t ON (t.old_groupid = e.old_groupid OR t.old_vendor =e.old_vendorid);

ALTER TABLE cdb_entries DROP old_groupid;
ALTER TABLE cdb_entries DROP old_vendorid;
ALTER TABLE cdb_tags DROP old_groupid;
ALTER TABLE cdb_tags DROP old_vendor;



-- -----------------------------------------------------------------
-- Convert os versions
-- -----------------------------------------------------------------
CREATE TABLE cdb_entries_tags (
  id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  revision BIGINT UNSIGNED NOT NULL,
  name VARCHAR( 30 ) NOT NULL,
  visible BOOL NOT NULL DEFAULT FALSE,
  old_osversion VARCHAR( 6 ) NOT NULL DEFAULT '000000'
) ENGINE = MYISAM;

INSERT INTO cdb_entries_tags VALUES
(NULL,     4, 'ReactOS 0.0.7',  FALSE, '000007'),
(NULL,    10, 'ReactOS 0.0.8',  FALSE, '000008'),
(NULL,    21, 'ReactOS 0.0.9',  FALSE, '000009'),
(NULL,    30, 'ReactOS 0.0.10', FALSE, '000010'),
(NULL,    39, 'ReactOS 0.0.11', FALSE, '000011'),
(NULL,    52, 'ReactOS 0.0.12', FALSE, '000012'),
(NULL,   503, 'ReactOS 0.0.14', FALSE, '000014'),
(NULL,   939, 'ReactOS 0.0.15', FALSE, '000015'),
(NULL,  2126, 'ReactOS 0.0.18', FALSE, '000018'),
(NULL,  2644, 'ReactOS 0.0.19', FALSE, '000019'),
(NULL,  3316, 'ReactOS 0.0.20', FALSE, '000020'),
(NULL,  3692, 'ReactOS 0.0.21', FALSE, '000021'),
(NULL,  4092, 'ReactOS 0.0.x',  TRUE,  '000010'),
(NULL,  4093, 'ReactOS 0.1.0',  TRUE,  '000100'),
(NULL,  4455, 'ReactOS 0.1.1',  TRUE,  '000110'),
(NULL,  4996, 'ReactOS 0.1.2',  TRUE,  '000120'),
(NULL,  5949, 'ReactOS 0.1.3',  TRUE,  '000130'),
(NULL,  6269, 'ReactOS 0.1.4',  TRUE,  '000140'),
(NULL,  6688, 'ReactOS 0.1.5',  TRUE,  '000150'),
(NULL,  7866, 'ReactOS 0.2.0',  TRUE,  '000200'),
(NULL,  8516, 'ReactOS 0.2.1',  TRUE,  '000210'),
(NULL,  9209, 'ReactOS 0.2.2',  TRUE,  '000220'),
(NULL,  9910, 'ReactOS 0.2.3',  TRUE,  '000230'),
(NULL, 10824, 'ReactOS 0.2.4',  TRUE,  '000240'),
(NULL, 13828, 'ReactOS 0.2.5',  TRUE,  '000250'),
(NULL, 14604, 'ReactOS 0.2.6',  TRUE,  '000260'),
(NULL, 17770, 'ReactOS 0.2.7',  TRUE,  '000270'),
(NULL, 18975, 'ReactOS 0.2.8',  TRUE,  '000280'),
(NULL, 20308, 'ReactOS 0.2.9',  TRUE,  '000290'),
(NULL, 23786, 'ReactOS 0.3.0',  TRUE,  '000300'),
(NULL, 26044, 'ReactOS 0.3.1',  TRUE,  '000310'),
(NULL, 29009, 'ReactOS 0.3.3',  TRUE,  '000330'),
(NULL, 31933, 'ReactOS 0.3.4',  TRUE,  '000340'),
(NULL, 34197, 'ReactOS 0.3.5',  TRUE,  '000350'),
(NULL, 35137, 'ReactOS 0.3.6',  TRUE,  '000360'),
(NULL, 37181, 'ReactOS 0.3.7',  TRUE,  '000370'),
(NULL, 39330, 'ReactOS 0.3.8',  TRUE,  '000380'),
(NULL, 66666, 'ReactOS 0.3.9',  TRUE,  '000390');



-- -----------------------------------------------------------------
-- set reported revisions
-- -----------------------------------------------------------------
UPDATE cdb_entries_reports r
SET revision = (SELECT revision FROM cdb_entries_tags WHERE old_osversion=r.old_osversion LIMIT 1);

ALTER TABLE cdb_entries_reports DROP old_osversion;



