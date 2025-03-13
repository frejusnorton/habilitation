SELECT DISTINCT
    'E' || BKEFR_#DATE_EXTRACT.neff  AS "reference"
FROM
     (
      SELECT 'BKEFR' AS TAB, BKEFR_#DATE_EXTRACT.*
      FROM BKEFR_#DATE_EXTRACT
      WHERE (
          BKEFR_#DATE_EXTRACT.VIE = '0'
          OR
          (BKEFR_#DATE_EXTRACT.VIE = '2' AND BKEFR_#DATE_EXTRACT.DECH  BETWEEN TO_DATE(:date_debut_periode, 'DD/MM/YYYY')
                        AND TO_DATE(:date_fin_periode, 'DD/MM/YYYY'))
      )
      UNION
      SELECT 'BKHISEFR' AS TAB, BKHISEFR_#DATE_EXTRACT.*
      FROM BKHISEFR_#DATE_EXTRACT
      WHERE (BKHISEFR_#DATE_EXTRACT.VIE = '9' AND BKHISEFR_#DATE_EXTRACT.DECH  BETWEEN TO_DATE(:date_debut_periode, 'DD/MM/YYYY')
                        AND TO_DATE(:date_fin_periode, 'DD/MM/YYYY'))
    ) BKEFR_#DATE_EXTRACT
WHERE
     BKEFR_#DATE_EXTRACT.type IN ( '150', '100' )
    AND ( ( BKEFR_#DATE_EXTRACT.dou <= TO_DATE(:date_fin_periode, 'DD/MM/YYYY')
            AND BKEFR_#DATE_EXTRACT.dech >= TO_DATE(:date_fin_periode, 'DD/MM/YYYY') )
          OR ( BKEFR_#DATE_EXTRACT.dech BETWEEN TO_DATE(:date_debut_periode, 'DD/MM/YYYY')
                        AND TO_DATE(:date_fin_periode, 'DD/MM/YYYY') ) )
