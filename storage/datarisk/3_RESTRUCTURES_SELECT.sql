select
    (
        select
            decode(
                trim(lib2),
                '280',
                'ORABANK TOGO',
                '284',
                'ORABANK BENIN',
                '236',
                'ORABANK BURKINA',
                '232',
                'ORABANK MALI',
                '240',
                'ORABANK NIGER',
                '248',
                'ORABANK SENEGAL',
                '272',
                'ORABANK CI',
                '257',
                'ORABANK GUINEE BISSAU',
                '314',
                'ORABANK GABON',
                '244',
                'ORABANK TCHAD',
                '228',
                'ORABANK MAURITANIE',
                '260',
                'ORABANK GUINEE'
            )
        from
            bknom
        where
            cacc = 'BANQUE'
    ) FILIALE,
    to_date(:DATE_EXTRACT, 'DD/MM/YYYY') "DATE_REFERENCE",
    trim(c.cli) "CODE_CLIENT",
    coalesce(
        (
            select
                max(s.cha)
            from
                bksld s
            where
                s.ncp = e.ncp
                and s.dco = to_date(:DATE_EXTRACT, 'DD/MM/YYYY')
        ),
        (
            select
                max(s.cha)
            from
                bkcom s
            where
                s.ncp = e.ncp
        )
    ) "CHAPITRE",
    a.eve "REFERENCE",
    e.ncp "NUM_COMPTE_ENGAGEMENT",
    trim(nom) || ' ' || trim(pre) "NOM_ET_PRENOMS",
    b.libe "TYPE_DE_CREDIT",
    mon "MONTANT_INITIAL_CREDIT",
    COALESCE(
        (
            select
                res
            from
                bkechprt ec
            where
                a.eve = ec.eve
                and a.ave = ec.ave
                and a.age = ec.age
                and num != 0
                and ec.dva =(
                    select
                        max(dva)
                    from
                        bkechprt ec1
                    where
                        ec1.dva <= to_date(:DATE_EXTRACT, 'DD/MM/YYYY')
                        and ec1.eve = ec.eve
                        and ec1.ave = ec.ave
                        and ec1.age = ec.age
                )
        ),
        a.mdb,
        (
            select
                amo_cal
            from
                bkechprt ec
            where
                a.eve = ec.eve
                and a.ave = ec.ave
                and a.age = ec.age
                and num != 0
                and ec.dva =(
                    select
                        max(dva)
                    from
                        bkechprt ec1
                    where
                        ec1.dva > to_date(:DATE_EXTRACT, 'DD/MM/YYYY')
                        and ec1.eve = ec.eve
                        and ec1.ave = ec.ave
                        and ec1.age = ec.age
                )
        )
    ) "ENCOURS_CREDIT",
    nvl(
        (
            select
                sum(- s.sdecv)
            from
                bksld s
            where
                s.cli = c.cli
                and s.ncp in (
                    select
                        ncp
                    from
                        bkcptprt
                    where
                        a.eve = eve
                        and a.ave = ave
                        and nat in ('006', '008')
                )
                and s.dco = to_date(:DATE_EXTRACT, 'DD/MM/YYYY')
        ),
        0
    ) "IMPAYE",
    to_char(a.dmep, 'DD/MM/YYYY') "DATE_MISE_EN_PLACE" --,a.map "ECHEANCE"
,
    to_char(a.dpec, 'DD/MM/YYYY') "DATE_PREMIERE_ECHEANCE",
    to_char(a.ddec, 'DD/MM/YYYY') "DATE_DERNIERE_ECHEANCE"
from
    bkdosprt a,
    bktyprt b,
    bkcli c,
    bkcptprt e