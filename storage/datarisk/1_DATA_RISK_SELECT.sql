Select
    FILIALE,
    to_char(DATE_EXTRACT, 'DD/MM/YYYY') "DATE REF",
    age AGENCE,
    cli "CODE CLIENT",
    nomrest "NOM CLIENT",
    sldescomp "SCOMPTE EFFET",
    SLDCPTCOURT "SOLDE CPT COURANT",
    cct "CREDIT COURT TERME",
    cmt "CREDIT MOYEN TERME",
    clt "CREDIT LONG TERME",
    cct_rest "CCT restructuré",
    cmt_rest "CMT restructuré",
    CLT_rest "CLT restructuré",
    creanratt "Créances rattachées",
    mntimp "MONTANT IMPAYE/ECH ATTANTE",
    mntdout "SOLDE DOUTEUX",
    CREDITDIR "TOTAL_CREDIT_DIRECT",
    CREDOC,
    CAUTIONS,
    HB_DOUTEUX "HB DOUTEUX",
    engsign "ENGAG PAR SIGNATURE",
    AUTRES_ENG_FINANCEMENTS,
    TOTENG "TotaL_Engagement",
    Titres,
    PIB,
    prov "PROVISION",
    prov_HB "PROVISION HORS BILAN",
    cptcred "COMPTES CREDITEURS",
    GEST "GESTIONNAIRE",
    codseg "CODE SEGMENTATION",
    seg "SEGMENTATION CLIENT",
    codesectact "CODE SECTEUR",
    sectact "SECTEUR ACTIVITE",
    codecatn "CODE AGENT ECONOMIQUE",
    libcatn "AGENT ECONOMIQUE"
from
    ora_datarisk
where
    (
        abs(SLDCPTCOURT) + abs(sldescomp) + abs(cct) + abs(cmt) + abs(clt) + abs(cct_rest) + abs(cmt_rest) + abs(clt_rest) + abs(mntimp) + abs(creanratt) + abs(mntdout) + abs(TOTENG) + abs(CREDOC) + abs(CAUTIONS) + abs(HB_DOUTEUX) + abs(AUTRES_ENG_FINANCEMENTS) + abs(engsign) + abs(Titres) + abs(PIB) + abs(prov) + abs(prov_HB) != 0
    )
order by
    TOTENG;