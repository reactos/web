

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
  checked BOOL NOT NULL DEFAULT FALSE,
  created DATETIME NOT NULL,
  visible BOOL NOT NULL DEFAULT FALSE,
  disabled BOOL NOT NULL DEFAULT TRUE,
  old_groupid BIGINT NOT NULL DEFAULT '0',
  old_osversion VARCHAR( 6 ) NOT NULL DEFAULT '000000',
  old_award SMALLINT NOT NULL DEFAULT '0'
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
  FALSE,
  comp_date,
  TRUE,
  FALSE,
  comp_groupid,
  comp_osversion,
  comp_award
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

