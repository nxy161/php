

--
SELECT us.id, us.name, us.address, us.birthday, st.name, gr.description, us.created FROM users AS us 
LEFT JOIN groups as gr 
ON us.main_group_id = gr.id
LEFT JOIN stores as st
ON us.main_store_id  = st.id
<!-- LEFT JOIN user_profiles as usp
ON us.id = usp.user_id; -->