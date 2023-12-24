
INSERT INTO tbl_course (ID, course_title, course_slug, course_thumbnail_link, course_is_public_course, course_is_delete, course_enable_qa, course_level)
SELECT
    p.ID,
    p.post_title,
    p.post_name,
    pm_thumbnail.meta_value AS thumbnail_link,
    -- pm_public_course.meta_value
    -- pm_public_course.meta_value AS is_public_course,
    CASE pm_public_course.meta_value WHEN 'yes' THEN 1 ELSE 0 END AS is_public_course,
    -- pm_enable_qa.meta_value AS enable_qa,
    CASE pm_enable_qa.meta_value WHEN 'yes' THEN 1 ELSE 0 END AS enable_qa,
    '0' AS is_delete, -- Assuming default value as '0'
    pm_course_level.meta_value AS course_level
FROM
    tbl_posts p
LEFT JOIN tbl_postmeta pm_thumbnail ON p.ID = pm_thumbnail.post_id AND pm_thumbnail.meta_key = '_thumbnail_id'
LEFT JOIN tbl_postmeta pm_public_course ON p.ID = pm_public_course.post_id AND pm_public_course.meta_key = '_tutor_is_public_course'
LEFT JOIN tbl_postmeta pm_enable_qa ON p.ID = pm_enable_qa.post_id AND pm_enable_qa.meta_key = '_tutor_enable_qa'
LEFT JOIN tbl_postmeta pm_course_level ON p.ID = pm_course_level.post_id AND pm_course_level.meta_key = '_tutor_course_level'
WHERE
    p.post_type = 'courses'
AND
    p.post_status = 'publish';


------------------------------------------------------------------------------


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


----

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

----


INSERT INTO tbl_quiz (
	topic_id,
	quiz_title,
	quiz_status,
	post_id
	)
SELECT
	p.post_parent,
	p.post_title,
	p.post_status,
	p.ID
FROM
    tbl_posts p
WHERE
    p.post_type = 'tutor_quiz'
AND
    p.post_status = 'publish';
