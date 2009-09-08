

-- -----------------------------------------------------------------
-- Drop obsolete tables
-- -----------------------------------------------------------------
/*DROP TABLE rsdb_item_devnet;
DROP TABLE rsdb_item_pack;
DROP TABLE rsdb_urls;
DROP TABLE _rsdb_users;
DROP TABLE rsdb_stats;
DROP TABLE rsdb_object_osversions; -- needs a manual convert to tag specific revisions
DROP TABLE _rsdb_item_comp_votes;
DROP TABLE rsdb_object_description;
DROP TABLE rsdb_group_bundles;
*/


-- -----------------------------------------------------------------
-- Convert categories
-- -----------------------------------------------------------------
DROP TABLE IF EXISTS cdb_categories; 
CREATE TABLE cdb_categories (
  id BIGINT UNSIGNED NOT NULL ,
  parent BIGINT UNSIGNED NULL COMMENT '->categories(id)',
  type ENUM('App','DLL','Drv', 'Oth') NOT NULL DEFAULT 'Oth',
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
    'App',
    cat_name,
    cat_description,
    cat_icon,
    TRUE
  FROM rsdb_categories
  WHERE cat_visible = '1' AND cat_comp = '1';

ALTER TABLE cdb_categories ORDER BY id;
/*DROP TABLE rsdb_categories;
*/

-- -----------------------------------------------------------------
-- Convert comments
-- -----------------------------------------------------------------
DROP TABLE IF EXISTS cdb_comments; 
CREATE TABLE cdb_comments (
  id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
  entry_id BIGINT UNSIGNED NOT NULL COMMENT '->entries(id)',
  parent BIGINT UNSIGNED NULL COMMENT '->comments(id)',
  user_id BIGINT UNSIGNED NOT NULL COMMENT '->roscms.accounts(id)',
  title VARCHAR( 100 ) NOT NULL ,
  content TEXT NOT NULL ,
  is_tipp BOOL NOT NULL DEFAULT FALSE,
  created DATETIME NOT NULL ,
  visible BOOL NOT NULL DEFAULT FALSE,
  test_id BIGINT UNSIGNED
) ENGINE = MYISAM COMMENT = 'parent xor entry_id has to be NULL';

INSERT INTO cdb_comments
SELECT
  fmsg_id,
  fmsg_comp_id,
  fmsg_parent,
  fmsg_user_id,
  fmsg_subject,
  fmsg_body,
  FALSE,
  fmsg_date,
  TRUE,
  NULL
  FROM rsdb_item_comp_forum;

/*DROP TABLE rsdb_item_comp_forum;
*/

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
  FALSE,
  test_date,
  TRUE,
  test_id
FROM rsdb_item_comp_testresults;
/*DROP TABLE rsdb_item_comp_testresults;
*/



-- -----------------------------------------------------------------
-- Convert attachements
-- -----------------------------------------------------------------
DROP TABLE IF EXISTS cdb_attachments; 
CREATE TABLE cdb_attachments (
  id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
  entry_id BIGINT UNSIGNED NOT NULL COMMENT '->entry(id)',
  user_id BIGINT UNSIGNED NOT NULL COMMENT '->roscms.users(id)',
  file VARCHAR( 250 ) NOT NULL ,
  type VARCHAR( 100 ) NOT NULL COMMENT 'content type',
  description TEXT NOT NULL ,
  created DATETIME NOT NULL ,
  visible BOOL NOT NULL DEFAULT FALSE,
  old_groupid BIGINT NOT NULL
) ENGINE = MYISAM;

INSERT INTO cdb_attachments
  SELECT
    media_id,
    0,
    media_user_id,
    media_file,
    media_filetype,
    media_description,
    media_date,
    TRUE,
    media_groupid
  FROM rsdb_object_media;

/*DROP TABLE rsdb_object_media;
*/



-- -----------------------------------------------------------------
-- Convert languages
-- -----------------------------------------------------------------
DROP TABLE IF EXISTS cdb_languages; 
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

/*DROP TABLE rsdb_languages;
*/


-- -----------------------------------------------------------------
-- Convert entries reports
-- -----------------------------------------------------------------
DROP TABLE IF EXISTS cdb_reports; 
CREATE TABLE cdb_reports (
  id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  entry_id BIGINT UNSIGNED NOT NULL COMMENT '->entries(id)',
  version_id BIGINT UNSIGNED NOT NULL COMMENT '->version(id)',
  comment_id BIGINT UNSIGNED NULL COMMENT '->comment(id)',
  revision BIGINT UNSIGNED NOT NULL,
  old_name VARCHAR( 100 ) NOT NULL,
  old_version VARCHAR( 100 ) NOT NULL,
  old_description TEXT NOT NULL,
  user_id BIGINT UNSIGNED NOT NULL COMMENT '->roscms.users(id)',
  works ENUM( 'full', 'part', 'not' ) NULL,
  checked BOOL NOT NULL DEFAULT FALSE,
  environment CHAR(4) NOT NULL DEFAULT 'unkn',
  environment_version VARCHAR(100) NOT NULL DEFAULT '',
  created DATETIME NOT NULL,
  visible BOOL NOT NULL DEFAULT FALSE,
  disabled BOOL NOT NULL DEFAULT TRUE,
  old_groupid BIGINT NOT NULL DEFAULT '0',
  old_osversion VARCHAR( 6 ) NOT NULL DEFAULT '000000',
  old_mediaid BIGINT NOT NULL
) ENGINE = MyISAM;

INSERT INTO cdb_reports
SELECT DISTINCT
  comp_id,
  0,
  0,
  NULL,
  0,
  comp_name,
  comp_appversion,
  comp_description,
  comp_usrid,
  NULL,
  FALSE,
  'unkn',
  '',
  comp_date,
  TRUE,
  FALSE,
  comp_groupid,
  comp_osversion,
  comp_media
FROM rsdb_item_comp
WHERE comp_date != '0000-00-00 00:00:00'
UNION
SELECT DISTINCT
  comp_id,
  0,
  0,
  NULL,
  0,
  comp_name,
  comp_appversion,
  comp_description,
  comp_usrid,
  NULL,
  FALSE,
  'unkn',
  '',
  '2006-04-03 00:00:00',
  TRUE,
  FALSE,
  comp_groupid,
  comp_osversion,
  comp_media
FROM rsdb_item_comp
WHERE comp_date = '0000-00-00 00:00:00';
 	

UPDATE cdb_reports r
SET works = IF((SELECT SUM(test_result_function)/COUNT(*) FROM rsdb_item_comp_testresults WHERE test_comp_id=r.id) = 5, 'full', IF((SELECT SUM(test_result_function)/COUNT(*) FROM rsdb_item_comp_testresults WHERE test_comp_id=r.id) = 1, 'not', 'part'));

ALTER TABLE cdb_reports CHANGE works works ENUM( 'full', 'part', 'not' ) NOT NULL DEFAULT 'not';




-- -----------------------------------------------------------------
-- Convert entries
-- -----------------------------------------------------------------
DROP TABLE IF EXISTS cdb_entries; 
CREATE TABLE cdb_entries (
  id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  type ENUM('App','DLL','Drv', 'Oth') NOT NULL DEFAULT 'Oth',
  name VARCHAR( 100 ) NOT NULL,
  category_id BIGINT NOT NULL,
  description TEXT NOT NULL,
  created DATETIME NOT NULL,
  modified DATETIME NOT NULL,
  visible BOOL NOT NULL DEFAULT FALSE,
  old_version VARCHAR( 100 ) NOT NULL,
  old_groupid BIGINT NOT NULL DEFAULT '0',
  old_vendorid BIGINT NOT NULL DEFAULT '0',
  old_name varchar(100),
  old_compid BIGINT,
  old_mediaid BIGINT
) ENGINE = MyISAM;

INSERT INTO cdb_entries
SELECT DISTINCT
  NULL,
  'App',
  g.grpentr_name,
  g.grpentr_category,
  COALESCE((SELECT i.old_description FROM cdb_reports i WHERE i.old_groupid=o.old_groupid ORDER BY i.created ASC LIMIT 1),g.grpentr_description) AS old_description,
  COALESCE((SELECT i.created FROM cdb_reports i WHERE i.old_groupid=o.old_groupid ORDER BY i.created ASC LIMIT 1),g.grpentr_date) AS created,
  COALESCE((SELECT i.created FROM cdb_reports i WHERE i.old_groupid=o.old_groupid ORDER BY i.created DESC LIMIT 1),g.grpentr_date) AS modified,
  TRUE,
  TRIM(REPLACE(o.old_name, g.grpentr_name, '')),
  g.grpentr_id,
  g.grpentr_vendor,
  o.old_name,
  o.id,
  o.old_mediaid
FROM rsdb_groups g
LEFT JOIN cdb_reports o ON g.grpentr_id=o.old_groupid;


UPDATE cdb_reports r
SET entry_id = (SELECT e.id FROM cdb_entries e WHERE r.old_name=e.old_name LIMIT 1);

UPDATE cdb_reports r
SET comment_id = (SELECT c.id FROM cdb_comments c WHERE c.entry_id=r.entry_id AND test_id IS NOT NULL ORDER BY created ASC LIMIT 1);

UPDATE cdb_comments c
SET entry_id = (SELECT e.id FROM cdb_entries e WHERE c.entry_id=e.old_compid LIMIT 1);

UPDATE cdb_attachments a
SET entry_id = (SELECT e.id FROM cdb_entries e WHERE a.id=e.old_mediaid LIMIT 1);

ALTER TABLE cdb_entries
  DROP old_compid,
  DROP old_mediaid;

ALTER TABLE cdb_reports
  DROP old_name,
  DROP old_description,
  DROP old_groupid,
  DROP old_version,
  DROP old_mediaid;
  
ALTER TABLE cdb_comments
  DROP test_id;

-- -----------------------------------------------------------------
-- Convert versions
-- -----------------------------------------------------------------
DROP TABLE IF EXISTS cdb_versions; 
CREATE TABLE cdb_versions (
  id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
  entry_id BIGINT UNSIGNED NOT NULL COMMENT '->entry',
  version VARCHAR( 20 ) NOT NULL,
  created DATETIME NOT NULL
) ENGINE = MYISAM;

INSERT INTO cdb_versions
SELECT
  NULL,
  id,
  old_version,
  created
FROM cdb_entries WHERE old_version IS NOT NULL;

UPDATE cdb_reports r
SET version_id = (SELECT v.id FROM cdb_versions v WHERE v.entry_id=r.entry_id LIMIT 1);

ALTER TABLE cdb_entries
  DROP old_name,
  DROP old_version;

-- DROP TABLE rsdb_item_comp;



-- -----------------------------------------------------------------
-- Convert tags
-- -----------------------------------------------------------------
DROP TABLE IF EXISTS cdb_tags; 
CREATE TABLE cdb_tags (
  id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
  name VARCHAR( 100 ) NOT NULL ,
  description TEXT NOT NULL ,
  user_id BIGINT UNSIGNED NOT NULL COMMENT '->roscms.users(id)',
  created DATETIME NOT NULL ,
  visible BOOL NOT NULL DEFAULT FALSE ,
  disabled BOOL NOT NULL DEFAULT TRUE ,
  old_vendor BIGINT,
  old_groupid BIGINT
) ENGINE = MYISAM;

-- vendors
INSERT INTO cdb_tags
SELECT DISTINCT
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

-- DROP TABLE rsdb_groups;
-- DROP TABLE rsdb_item_vendor;



-- -----------------------------------------------------------------
-- Convert logs
-- -----------------------------------------------------------------
DROP TABLE IF EXISTS cdb_logs; 
CREATE TABLE cdb_logs (
  id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
  user_id BIGINT UNSIGNED NOT NULL COMMENT '->roscms.users(id)',
  content TEXT NOT NULL ,
  created DATETIME NOT NULL
) ENGINE = MYISAM;

INSERT INTO cdb_logs
SELECT
  log_id,
  log_usrid,
  CONCAT(log_title,'

',log_description),
  log_date
FROM rsdb_logs;

-- DROP TABLE rsdb_logs;



ALTER TABLE cdb_entries DROP old_groupid;
ALTER TABLE cdb_tags DROP old_groupid;
-- -----------------------------------------------------------------
-- remove double entries
-- -----------------------------------------------------------------
DROP TABLE IF EXISTS cdb_entries2; 
CREATE TABLE cdb_entries2 SELECT * FROM cdb_entries;
TRUNCATE TABLE cdb_entries2;
ALTER TABLE cdb_entries2  ENGINE = MYISAM;

INSERT INTO cdb_entries2
SELECT DISTINCT
  (SELECT id FROM cdb_entries WHERE name = g.name ORDER BY created DESC LIMIT 1),
  g.type,
  name,
  (SELECT category_id FROM cdb_entries WHERE name = g.name ORDER BY created DESC LIMIT 1),
  (SELECT description FROM cdb_entries WHERE name = g.name ORDER BY created DESC LIMIT 1),
  (SELECT created FROM cdb_entries WHERE name = g.name ORDER BY created ASC LIMIT 1),
  (SELECT modified FROM cdb_entries WHERE name = g.name ORDER BY created DESC LIMIT 1),
  TRUE,
  (SELECT old_vendorid FROM cdb_entries WHERE name = g.name ORDER BY created DESC LIMIT 1)
FROM cdb_entries g;

-- old -> new
DROP TABLE IF EXISTS temp_entries;
CREATE TABLE temp_entries (
  new_id BIGINT NOT NULL,
  old_id BIGINT NOT NULL PRIMARY KEY
) ENGINE=MYISAM;

INSERT INTO temp_entries
SELECT
  n.id,
  o.id
FROM cdb_entries2 n JOIN cdb_entries o ON o.name=n.name;


UPDATE cdb_reports r
SET entry_id=(SELECT n.new_id FROM temp_entries n WHERE n.old_id=r.entry_id);

UPDATE cdb_versions v
SET entry_id=(SELECT n.new_id FROM temp_entries n WHERE n.old_id=v.entry_id);

UPDATE cdb_comments c
SET entry_id=(SELECT n.new_id FROM temp_entries n WHERE n.old_id=c.entry_id);

UPDATE cdb_attachments a
SET entry_id=(SELECT n.new_id FROM temp_entries n WHERE n.old_id=a.entry_id);


-- DROP TABLE cdb_entries;
DROP TABLE IF EXISTS cdb_entries; 
RENAME TABLE cdb_entries2 TO cdb_entries;
ALTER TABLE cdb_entries
  ADD UNIQUE(type, name),
  ADD PRIMARY KEY(id),
  CHANGE id id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT;



-- -----------------------------------------------------------------
-- Convert tag assignments
-- -----------------------------------------------------------------
DROP TABLE IF EXISTS cdb_rel_entries_tags; 
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
JOIN cdb_tags t ON (t.old_vendor = e.old_vendorid);


ALTER TABLE cdb_entries DROP old_vendorid;
ALTER TABLE cdb_tags DROP old_vendor;
  


-- -----------------------------------------------------------------
-- remove double versions
-- -----------------------------------------------------------------
DROP TABLE IF EXISTS cdb_versions2; 
CREATE TABLE cdb_versions2 SELECT * FROM cdb_versions;
TRUNCATE TABLE cdb_versions2;
ALTER TABLE cdb_versions2  ENGINE = MYISAM;

INSERT INTO cdb_versions2
SELECT DISTINCT
  (SELECT id FROM cdb_versions WHERE entry_id=g.entry_id AND version=g.version ORDER BY created DESC LIMIT 1),
  entry_id,
  version,
  (SELECT created FROM cdb_versions WHERE entry_id=g.entry_id AND version=g.version ORDER BY created ASC LIMIT 1)
FROM cdb_versions g;

-- old -> new
DROP TABLE IF EXISTS temp_versions;
CREATE TABLE temp_versions (
  new_id BIGINT NOT NULL,
  old_id BIGINT NOT NULL PRIMARY KEY
) ENGINE=MYISAM;

INSERT INTO temp_versions
SELECT
  n.id,
  o.id
FROM cdb_versions2 n JOIN cdb_versions o ON o.entry_id=n.entry_id AND o.version=n.version;


UPDATE cdb_reports r
SET version_id=(SELECT n.new_id FROM temp_versions n WHERE n.old_id=r.version_id);
  
-- replace duplicate versions
DROP TABLE IF EXISTS cdb_versions; 
RENAME TABLE cdb_versions2 TO cdb_versions;
ALTER TABLE cdb_versions
  ADD UNIQUE(entry_id, version),
  ADD PRIMARY KEY(id),
  CHANGE id id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT;



-- -----------------------------------------------------------------
-- Convert os versions
-- -----------------------------------------------------------------
DROP TABLE IF EXISTS cdb_os; 
CREATE TABLE cdb_os (
  id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  revision BIGINT UNSIGNED NOT NULL,
  name VARCHAR( 30 ) NOT NULL,
  visible BOOL NOT NULL DEFAULT FALSE,
  old_osversion VARCHAR( 6 ) NOT NULL DEFAULT '000000'
) ENGINE = MYISAM;

INSERT INTO cdb_os VALUES
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
(NULL, 40702, 'ReactOS 0.3.9',  TRUE,  '000390'),
(NULL, 41757, 'ReactOS 0.3.10', TRUE,  '003100');



-- -----------------------------------------------------------------
-- assign bugs to an app
-- -----------------------------------------------------------------
DROP TABLE IF EXISTS cdb_rel_entries_bugs; 
CREATE TABLE cdb_rel_entries_bugs (
  version_id BIGINT UNSIGNED NOT NULL COMMENT '->version(id)',
  entry_id BIGINT UNSIGNED NOT NULL COMMENT '->entry(id)',
  bug_id BIGINT UNSIGNED NOT NULL COMMENT '->bugs(id)',
  PRIMARY KEY ( version_id , bug_id )
) ENGINE = MYISAM;



-- -----------------------------------------------------------------
-- set reported revisions
-- -----------------------------------------------------------------
UPDATE cdb_reports r
SET revision = (SELECT revision FROM cdb_os WHERE old_osversion=r.old_osversion LIMIT 1);

ALTER TABLE cdb_reports DROP old_osversion;
ALTER TABLE cdb_os DROP old_osversion;
ALTER TABLE cdb_attachments DROP old_groupid;
DROP TABLE temp_entries;
DROP TABLE temp_versions;



-- -----------------------------------------------------------------
-- create table for user settings
-- -----------------------------------------------------------------
CREATE TABLE cdb_settings (
  id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
  type VARCHAR( 10 ) NOT NULL ,
  name VARCHAR( 30 ) NOT NULL ,
  user_id BIGINT UNSIGNED NOT NULL COMMENT '->roscms_accounts(id)',
  value TEXT NOT NULL ,
  created DATETIME NOT NULL ,
  modified DATETIME NOT NULL ,
  UNIQUE (type, name, user_id)
) ENGINE = MYISAM;

