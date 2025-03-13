SELECT distinct
(
    SELECT TRIM(N.LIB1)
    FROM BKNOM N
    WHERE N.CACC = 'BANQUE'
) "FILIALE",
:V_DATE "DATE DE REFERENCE",
S.CLI "CODE CLIENT",
S.NCP "NUMERO_COMPTE_GARANTIE",
(
    SELECT NOMREST
    FROM BKCLI
    WHERE BKCLI.CLI=S.CLI
) "NOM_ET_PRENOMS",
TRIM(GA.CNAT) "CODE_NATURE_GARANTIE",
TRIM(N.LIB) "LIBELLE_NATURE_GARANTIE",
S.SDECV "MONTANT_GARANTIE",
(
    select to_char(min(ga0.ddm), 'DD/MM/YYYY')
    from bkgar ga0
    where ga0.ncpte=ga.ncpte
    and ga.cnat=n.cnat
    and ga0.dco<=to_date(:V_DATE, 'DD/MM/YYYY')
)  "DATE_INSCRIPTION",
(
    select to_char(max(ga0.dech), 'DD/MM/YYYY')
    from bkgar ga0
    where ga0.ncpte=ga.ncpte
    and ga.cnat=n.cnat
    and ga0.dco<=to_date(:V_DATE, 'DD/MM/YYYY')
) "DATE_ECHEANCE"
FROM BKGAR GA
JOIN BKSLD S ON S.NCP = GA.NCPTE
LEFT JOIN BKNATG N ON GA.CNAT = N.CNAT
WHERE S.DCO = TO_DATE(:V_DATE, 'DD/MM/YYYY')
AND GA.DCO <= TO_DATE(:V_DATE, 'DD/MM/YYYY')
AND S.SDECV > 0
AND s.CLI != ' '
and s.CLI NOT IN (
	SELECT TRIM(N.LIB2)
	FROM BKNOM N
	WHERE N.CTAB = '323'
);
