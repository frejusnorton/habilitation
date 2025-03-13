SELECT
    DISTINCT (
        'C' || bkcau_#DATE_EXTRACT.eve) ContractCode
        FROM
            bkcau_#DATE_EXTRACT
        WHERE
            bkcau_#DATE_EXTRACT.dou <= TO_DATE(:date_fin_periode, 'DD/MM/YYYY')
            AND bkcau_#DATE_EXTRACT.mon > 0
            AND bkcau_#DATE_EXTRACT.eta IN ('VA', 'FO', 'VF')
            AND (
                bkcau_#DATE_EXTRACT.ctr <> '9'
                OR (
                    bkcau_#DATE_EXTRACT.ctr = '9'
                    AND (
                        bkcau_#DATE_EXTRACT.dmo BETWEEN TO_DATE(:date_debut_periode, 'DD/MM/YYYY')
                        AND TO_DATE(:date_fin_periode, 'DD/MM/YYYY')
                    )
                )
            )
            AND bkcau_#DATE_EXTRACT.dou >= TO_DATE('01/01/2021', 'DD/MM/YYYY')
            AND bkcau_#DATE_EXTRACT.dev = '952'
