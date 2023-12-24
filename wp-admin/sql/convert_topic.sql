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

-- TABLE: tbl_topic
-- 1	ID Primary	int			No	None		AUTO_INCREMENT	Change Change	Drop Drop	
-- 	2	course_id	int			No	None			Change Change	Drop Drop	-- post_parent
-- 	3	topic_title	varchar(255)	utf8mb4_unicode_ci		No	None			Change Change	Drop Drop	 -- post_title
-- 	4	topic_sumary	varchar(255)	utf8mb4_unicode_ci		No	None			Change Change	Drop Drop -- post_content
-- 	5	post_id Primary	int			No	None			Change Change	Drop Drop	

-- write SQL to convert all datas from tbl_post 


INSERT INTO tbl_topic (
	course_id,
	topic_title,
	topic_sumary,
	post_id
	)
SELECT
	p.post_parent,
	p.post_title,
	p.post_content,
	p.ID
FROM
    tbl_posts p
WHERE
    p.post_type = 'topics'
AND
    p.post_status = 'publish';
