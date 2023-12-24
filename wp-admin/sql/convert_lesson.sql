-- TABLE: tbl_posts
-- 1	ID PrimaryIndex	bigint		UNSIGNED	No	None		AUTO_INCREMENT	Change Change	Drop Drop	
-- 	2	post_author Index	bigint		UNSIGNED	No	0			Change Change	Drop Drop	
-- 	3	post_date Index	datetime			No	0000-00-00 00:00:00			Change Change	Drop Drop	
-- 	4	post_date_gmt	datetime			No	0000-00-00 00:00:00			Change Change	Drop Drop	
-- 	5	post_content	longtext	utf8mb4_unicode_520_ci		No	None			Change Change	Drop Drop	
-- 	6	post_title	text	utf8mb4_unicode_520_ci		No	None			Change Change	Drop Drop	
-- 	7	post_excerpt	text	utf8mb4_unicode_520_ci		No	None			Change Change	Drop Drop	
-- 	8	post_status Index	varchar(20)	utf8mb4_unicode_520_ci		No	publish			Change Change	Drop Drop	
-- 	9	comment_status	varchar(20)	utf8mb4_unicode_520_ci		No	open			Change Change	Drop Drop	
-- 	10	ping_status	varchar(20)	utf8mb4_unicode_520_ci		No	open			Change Change	Drop Drop	
-- 	11	post_password	varchar(255)	utf8mb4_unicode_520_ci		No				Change Change	Drop Drop	
-- 	12	post_name Index	varchar(200)	utf8mb4_unicode_520_ci		No				Change Change	Drop Drop	
-- 	13	to_ping	text	utf8mb4_unicode_520_ci		No	None			Change Change	Drop Drop	
-- 	14	pinged	text	utf8mb4_unicode_520_ci		No	None			Change Change	Drop Drop	
-- 	15	post_modified	datetime			No	0000-00-00 00:00:00			Change Change	Drop Drop	
-- 	16	post_modified_gmt	datetime			No	0000-00-00 00:00:00			Change Change	Drop Drop	
-- 	17	post_content_filtered	longtext	utf8mb4_unicode_520_ci		No	None			Change Change	Drop Drop	
-- 	18	post_parent Index	bigint		UNSIGNED	No	0			Change Change	Drop Drop	
-- 	19	guid	varchar(255)	utf8mb4_unicode_520_ci		No				Change Change	Drop Drop	
-- 	20	menu_order	int			No	0			Change Change	Drop Drop	
-- 	21	post_type Index	varchar(20)	utf8mb4_unicode_520_ci		No	post			Change Change	Drop Drop	
-- 	22	post_mime_type	varchar(100)	utf8mb4_unicode_520_ci		No				Change Change	Drop Drop	
-- 	23	comment_count	bigint

-- TABLE: tbl_postmeta
	-- 1	meta_id Primary	bigint		UNSIGNED	No	None		AUTO_INCREMENT	Change Change	Drop Drop	
	-- 2	post_id Index	bigint		UNSIGNED	No	0			Change Change	Drop Drop	
	-- 3	meta_key Index	varchar(255)	utf8mb4_unicode_520_ci		Yes	NULL			Change Change	Drop Drop	
	-- 4	meta_value	longtext	utf8mb4_unicode_520_ci		Yes	NULL			Change Change	Drop Drop	

-- TABLE: tbl_lesson
	-- 1	ID Primary	int			No	None		AUTO_INCREMENT	Change Change	Drop Drop	
	-- 2	post_id	int			No	None			Change Change	Drop Drop	
	-- 3	topic_id	varchar(255)	utf8mb4_unicode_ci		No	None			Change Change	Drop Drop	
	-- 4	lesson_title	varchar(255)	utf8mb4_unicode_ci		No	None			Change Change	Drop Drop	
	-- 5	lesson_video	text	utf8mb4_unicode_ci		No	None			Change Change	Drop Drop	
	-- 6	lesson_attachments	varchar(255)	utf8mb4_unicode_ci		No	None			Change Change	Drop Drop	
	-- 7	lesson_decription	varchar(255)	utf8mb4_unicode_ci		No	None			Change Change	Drop Drop	
	-- 8	lesson_status	varchar(255)	utf8mb4_unicode_ci		No	None			Change Change	Drop Drop	
	-- 9	create_date	datetime			No	CURRENT_TIMESTAMP		DEFAULT_GENERATED	Change Change	Drop Drop	
	-- 10	data_meta	varchar(255)	utf8mb4_unicode_ci		No	None			Change Change	Drop Drop	


-- data of postmeta
-- 14178
-- 15897
-- _video
-- a:9:{s:6:"source";s:7:"youtube";s:15:"source_video...
-- 15897
-- 1
-- 2023-12-24 01:13:52
-- 2023-12-24 01:13:52
-- Lesson Demo 01
-- publish
-- open
-- closed
-- lesson-demo-01
-- 2023-12-24 01:13:52
-- 2023-12-24 01:13:52
-- 15895
-- https://mythosedu.com/courses/course-demo-01/lesso...
-- 1
-- lesson
-- 0

-- write SQL to convert all datas from tbl_post and tbl_postmeta into tbl_course: Get value from tbl_posts and tbl_postmeta with tbl_course.ID = post_id, its value is in meta_value column, and somes of the tbl_posts


INSERT INTO tbl_lesson (
	post_id,
	topic_id,
	lesson_title,
	lesson_video,
	lesson_attachments,
	lesson_decription,
	lesson_status,
	create_date,
	data_meta
	)
SELECT
	p.ID,
	p.post_parent,
	p.post_title,
	pm_video.meta_value,
	'',
	p.post_excerpt,
	p.post_status,
	p.post_date,
	pm_metadata.meta_value
FROM
    tbl_posts p
LEFT JOIN tbl_postmeta pm_video ON p.ID = pm_video.post_id AND pm_video.meta_key = '_video'
LEFT JOIN tbl_postmeta pm_metadata ON p.ID = pm_metadata.post_id AND pm_metadata.meta_key = '_tutorstarter_schema'
WHERE
    p.post_type = 'lesson'
AND
    p.post_status = 'publish';