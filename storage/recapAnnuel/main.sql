SELECT T.CLI, T.CATGFRA, TRIM(ora_correct_car(dbedi.ora_cleanText(dbedi.ora_getlibcatgfra(T.CATGFRA)))) LIBCATGFRA,
SUM(DECODE(T.SEN, 'D', T.MON, 'C', -T.MON, 0)) MON
FROM DBEDI.EXT_RECAP_MVTS_DATA_FINAL T
WHERE T.CLI = :cli
AND TRIM(T.NCP)||TRIM(T.NAT) NOT IN (
    SELECT TRIM(CPT.NCP)||'RRCMON'
    FROM BKCOM CPT
    WHERE CPT.CHA LIKE '6%'
)
AND T.NAT NOT IN ('PROPRT', 'EXTPRO')
GROUP BY T.CLI, T.CATGFRA, TRIM(dbedi.ora_correct_car(dbedi.ora_cleanText(dbedi.ora_getlibcatgfra(T.CATGFRA))))
