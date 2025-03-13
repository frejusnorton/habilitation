select
    distinct bkimp.FILIALE "filiale",
    bkimp.DATREF "date_reference",
    bkimp.CLI "code_client",
    bkimp.chapitre,
    bkimp.eve "reference",
    bkimp.ncp "compte_impaye",
    bkimp.nom "nom_et_prenom",
    sum(sdecv) "montant_impaye",
    DATE_PREM_IMP_D "date_premier_impaye",
    nvl(
        (
            select
                sum(sl.sdecv)
            from
                BKSLD sl,
                bkcptprt n
            where
                sl.dco = bkimp.DATREF
                and sl.ncp = n.ncp
                and bkimp.eve = n.eve
                and n.ave = 0
                and n.nat = '004'
        ),
        0
    ) "encours",
    case
        when bkimp.typ in ('009', '012') then 'OUI'
        else 'NON'
    end "credit_immobilier"
from
    ora_datarisk_IMP bkimp
group by
    bkimp.AGENCE,
    bkimp.FILIALE,
    bkimp.DATREF,
    bkimp.CLI,
    bkimp.chapitre,
    bkimp.nom,
    DATE_PREM_IMP_D,
    bkimp.typ,
    bkimp.eve,
    bkimp.ncp --,bkimp.ENCOURS
having
    sum(sdecv) < 0
order by
    chapitre