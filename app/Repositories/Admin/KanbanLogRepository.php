SELECT 
    kanbanLog.card_id,
    (SELECT title FROM kanban WHERE id = kanbanLog.card_id) AS titulo,
    
    kanbanLog.column_index_old,
    
    (SELECT text FROM kanbanColumns WHERE id = (kanbanLog.column_index_old )) AS old,
    
    kanbanLog.column_index_new,
    
    (SELECT text FROM kanbanColumns WHERE id = (kanbanLog.column_index_new )) AS novo,
    
    DATE_FORMAT(kanbanLog.created_at, '%d/%m/%Y %H:%i:%s') AS criado_em,
    DATE_FORMAT(kanbanLog.updated_at, '%d/%m/%Y %H:%i:%s') AS movido
FROM kanbanLog
WHERE kanbanLog.card_id = 22;