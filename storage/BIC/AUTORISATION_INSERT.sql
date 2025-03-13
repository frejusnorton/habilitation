select
CASE
        WHEN ( bkautc_#DATE_EXTRACT.eve = ' '
               OR bkautc_#DATE_EXTRACT.eve IS NULL ) THEN
            ( 'A'
              || '000000'
              || lpad(TRIM(bkautc_#DATE_EXTRACT.naut), 9, '0') )
        ELSE
            ( 'A'
              || lpad(TRIM(bkautc_#DATE_EXTRACT.eve), 6, '0')
              || lpad(TRIM(bkautc_#DATE_EXTRACT.naut), 9, '0') )
    END         AS "reference"
from bkautc_#DATE_EXTRACT
WHERE bkautc_#DATE_EXTRACT.maut > 0
    AND bkautc_#DATE_EXTRACT.eta IN ( 'VA', 'FO', 'VF' )
    AND ( bkautc_#DATE_EXTRACT.fin BETWEEN TO_DATE(:date_debut_periode, 'DD/MM/YYYY')
                                          AND TO_DATE(:date_fin_periode, 'DD/MM/YYYY')
          OR bkautc_#DATE_EXTRACT.fin >= TO_DATE(:date_fin_periode, 'DD/MM/YYYY') )
