select
    (
        select
            trim(lib1)
        from
            bknom
        where
            cacc = 'BANQUE'
    ) "FILIALE",
    a.dco "DATE_DE_REFERENCE",
    a.cha "CHAPITRE",
    a.dev "DEVISE",
    CASE
        WHEN (
            a.cli is null
            or a.cli like ' %'
        ) THEN concat('CHA', a.cha)
        ELSE a.cli
    end "CODE_CLIENT",
    a.ncp "COMPTE",
    nvl(
        (
            select
                nomrest
            from
                bkcli
            where
                a.cli = bkcli.cli
        ),
        b.inti
    ) "CLIENT",
    b.inti "INTITULE_COMPTE",
    nvl(
        (
            select
                max(ope)
            from
                bkcau
            where
                ncpe = a.ncp
        ),
        'C99'
    ) "CODE_OPERATION",
    - a.sdecv "SOLDE_DU_COMPTE",
    b.dodb "DATE_PASSAGE_EN_DEBIT"
from
    bksld a,
    bkcom b
where
    a.ncp = b.ncp
    and a.age = b.age
    and a.dev = b.dev
    and (
        a.cha like '913%'
        or a.cha like '99%'
    )
    and a.cha not like '993%'
    and a.cha not like '9999%'
    and a.sdecv < 0
    and a.dco = to_date(:DATE_EXTRACT, 'DD/MM/YYYY')
union
select
    (
        select
            trim(lib1)
        from
            bknom
        where
            cacc = 'BANQUE'
    ) "FILIALE",
    a.dco "DATE_DE_REFERENCE",
    a.cha "CHAPITRE",
    a.dev "DEVISE",
CASE
        WHEN (
            a.cli is null
            or a.cli like ' %'
        ) THEN concat('CHA', a.cha)
        ELSE a.cli
    end "CODE_CLIENT",
    a.ncp "COMPTE",
    nvl(
        (
            select
                nomrest
            from
                bkcli
            where
                a.cli = bkcli.cli
        ),
        b.inti
    ) "CLIENT",
    b.inti "INTITULE_COMPTE",
    'CDI' "CODE_OPERATION",
    - a.sdecv "SOLDE_DU_COMPTE",
    b.dodb "DATE_PASSAGE_EN DEBIT"
from
    bksld a,
    bkcom b
where
    a.ncp = b.ncp
    and a.age = b.age
    and a.dev = b.dev
    and (
        a.cha like '903%'
        or a.cha like '911%'
    )
    and a.cha not like '903100%'
    and a.cha not like '9036%'
    and a.sdecv < 0
    and a.dco = to_date(:DATE_EXTRACT, 'DD/MM/YYYY')