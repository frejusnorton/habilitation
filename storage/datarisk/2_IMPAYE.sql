
Create table ora_datarisk_IMP (
AGENCE varchar2(10),
FILIALE varchar2(100),
DATREF date,
CLI varchar2(15),
CHAPITRE varchar2(10),
ncp varchar2(11),
nom varchar2(100),
sdecv numeric,
DATE_PREM_IMP_D date,
typ varchar2(6),
eve varchar2(10),
PRIMARY key(AGENCE,CLI,ncp))

##
INSERT INTO ora_datarisk_IMP
SELECT 
    s.age AS AGENCE,
    (
        SELECT 
            DECODE(
                TRIM(lib2),
                '280', 'ORABANK TOGO',
                '284', 'ORABANK BENIN',
                '236', 'ORABANK BURKINA',
                '232', 'ORABANK MALI',
                '240', 'ORABANK NIGER',
                '248', 'ORABANK SENEGAL',
                '272', 'ORABANK CI',
                '257', 'ORABANK GUINEE BISSAU',
                '314', 'ORABANK GABON',
                '244', 'ORABANK TCHAD',
                '228', 'ORABANK MAURITANIE',
                '260', 'ORABANK GUINEE'
            )
        FROM bknom 
        WHERE cacc = 'BANQUE'
    ) AS FILIALE,
    s.dco AS DATREF,
    s.CLI, 
    s.cha, 
    s.ncp,
    (
        SELECT nomrest 
        FROM bkcli 
        WHERE bkcli.cli = s.cli
    ) AS nom, 
    s.sdecv,
    NVL(
        (
            SELECT MIN(e.dva)
            FROM bkechprt e
            JOIN bkinipeprt i ON e.age = i.age AND e.eve = i.eve AND e.ave = i.ave AND e.num = i.num
            JOIN bkdosprt d ON e.age = d.age AND e.eve = d.eve AND e.ave = d.ave
            JOIN bkcptprt p ON d.age = p.age AND d.eve = p.eve AND d.ave = p.ave AND p.ncp = s.ncp
            WHERE 
                p.nat IN ('006', '008') 
                AND e.dva <= TO_DATE(:DATE_EXTRACT, 'DD/MM/YYYY')
                AND i.darr_ini >= TO_DATE(:DATE_EXTRACT, 'DD/MM/YYYY')
        ),
        NVL(
            (
                SELECT MIN(e.dva)
                FROM bkechprt e
                JOIN bkdosprt d ON e.age = d.age AND e.eve = d.eve AND e.ave = d.ave
                JOIN bkcptprt p ON d.age = p.age AND d.eve = p.eve AND d.ave = p.ave AND p.ncp = s.ncp
                WHERE 
                    p.nat IN ('006', '008') 
                    AND e.ctr = '7' 
                    AND e.dva <= TO_DATE(:DATE_EXTRACT, 'DD/MM/YYYY')
            ),
            NVL(
                ora_date_debit(s.sde, s.age, s.ncp, TO_DATE(:DATE_EXTRACT, 'DD/MM/YYYY')),
                (
                    SELECT MIN(m.dco)
                    FROM bkhis m
                    WHERE m.age = s.age AND m.ncp = s.ncp AND m.sen = 'D'
                )
            )
        )
    ) AS DATE_PREM_IMP_D,
    (
        SELECT MAX(d.typ) 
        FROM bkdosprt d 
        JOIN bkcptprt p ON d.eve = p.eve AND d.ave = p.ave AND p.ncp = s.ncp
    ) AS typ,
    (
        SELECT MAX(d.eve) 
        FROM bkdosprt d 
        JOIN bkcptprt p ON d.eve = p.eve AND d.ave = p.ave AND p.ncp = s.ncp
    ) AS eve
FROM bksld s
WHERE 
    (s.cha LIKE '20113%' 
    OR s.cha LIKE '20123%'  
    OR s.cha LIKE '20213%' 
    OR s.cha LIKE '20223%' 
    OR s.cha LIKE '20233%' 
    OR s.cha LIKE '2033%' 
    OR s.cha LIKE '2043%' 
    OR s.cha LIKE '2913%')
    AND NOT EXISTS(
        SELECT 1 
        FROM bkcptprt 
        WHERE s.ncp = bkcptprt.ncp 
        AND bkcptprt.nat = '004'
    )
    AND s.dco = TO_DATE(:DATE_EXTRACT, 'DD/MM/YYYY')
    AND s.sdecv != 0





