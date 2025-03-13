SELECT DISTINCT

    bkdosprt_#DATE_EXTRACT.eve || bkdosprt_#DATE_EXTRACT.ave                                      AS "reference"
FROM
bkdosprt_#DATE_EXTRACT,bkcliprt_#DATE_EXTRACT

WHERE  bkdosprt_#DATE_EXTRACT.eta = 'VA'
    AND bkdosprt_#DATE_EXTRACT.mdb != 0
    AND bkdosprt_#DATE_EXTRACT.mon > 0

    AND bkdosprt_#DATE_EXTRACT.dmep <= TO_DATE(:date_fin_periode, 'DD/MM/YYYY')
    AND bkcliprt_#DATE_EXTRACT.eve = bkdosprt_#DATE_EXTRACT.eve
    AND bkcliprt_#DATE_EXTRACT.ave = bkdosprt_#DATE_EXTRACT.ave
    AND ( bkdosprt_#DATE_EXTRACT.ctr <> '9'
          OR ( bkdosprt_#DATE_EXTRACT.ctr = '9'
               AND ( ( dtan IS NULL
                       AND bkdosprt_#DATE_EXTRACT.ddec BETWEEN TO_DATE(:date_debut_periode, 'DD/MM/YYYY')
                                          AND TO_DATE(:date_fin_periode, 'DD/MM/YYYY') )  )
                     OR ( dtan IS NOT NULL
                          AND bkdosprt_#DATE_EXTRACT.dtan BETWEEN TO_DATE(:date_debut_periode, 'DD/MM/YYYY')
                                          AND TO_DATE(:date_fin_periode, 'DD/MM/YYYY') ) ) )

