select
    (
        select
            trim(lib1)
        from
            bknom
        where
            cacc = 'BANQUE'
    ) "FILIALE",
    trim(c.cli) "CODE_CLIENT",
    (
        select
            max(ncp)
        from
            bkcptprt z
        where
            z.age = a.age
            and z.eve = a.eve
            and z.ave = a.ave
            and z.nat = '004'
    ) "NUMERO_DU_COMPTE",
    (
        select
            max(cha)
        from
            bkcom x
        where
            x.ncp =(
                select
                    max(ncp)
                from
                    bkcptprt z
                where
                    z.age = a.age
                    and z.eve = a.eve
                    and z.ave = a.ave
                    and z.nat = '004'
            )
    ) "CHAPITRE",
    a.dev "DEVISE_DU_PRET",
    a.eve || to_char(a.ave, 'FM00') "REFERENCE_DU_DOSSIER",
    c.nomrest "NOM_CLIENT",
    :DATE_EXTRACT "DATE_DE_REFERENCE",
    b.libe "TYPE_DE_CREDIT",
    a.mon "NOMINAL_EN_DEVISE",
    nvl(
        (
            select
                min(res)
            from
                bkechprt ec
            where
                a.eve = ec.eve
                and a.ave = ec.ave
                and a.age = ec.age
                and num != 0
                and dva <= to_date(:DATE_EXTRACT, 'DD/MM/YYYY')
            group by
                eve,
                ave,
                age
        ),
        a.mdb
    ) *(1) "ENCOURS_EN_DEVISE",
    nvl(
        (
            select
                min(z.mimp)
            from
                bkdosprt z,
                bkcptprt y,
                bkcom t
            where
                a.eve = z.eve
                and a.ave = z.ave
                and z.eve = y.eve
                and a.ave = y.ave
                and y.ncp = t.ncp
                and t.sde < 0
        ),
        0
    ) "IMPAYES_EN_DEVISE",
    a.mon * nvl(
        (
            select
                tx.tind
            from
                bktau tx
            where
                tx.dev = a.dev
                and dco =(
                    select
                        max(dco)
                    from
                        bktau
                    where
                        dco <= to_date(:DATE_EXTRACT, 'DD/MM/YYYY')
                )
        ),
        1
    ) "NOMINAL_EN_GNF",
    nvl(
        (
            select
                min(res)
            from
                bkechprt ec
            where
                a.eve = ec.eve
                and a.ave = ec.ave
                and a.age = ec.age
                and num != 0
                and dva <= to_date(:DATE_EXTRACT, 'DD/MM/YYYY')
            group by
                eve,
                ave,
                age
        ),
        a.mdb
    ) *(1) * nvl(
        (
            select
                tx.tind
            from
                bktau tx
            where
                tx.dev = a.dev
                and dco =(
                    select
                        max(dco)
                    from
                        bktau
                    where
                        dco <= to_date(:DATE_EXTRACT, 'DD/MM/YYYY')
                )
        ),
        1
    ) "ENCOURS_EN_GNF",
    nvl(
        (
            select
                min(z.mimp)
            from
                bkdosprt z,
                bkcptprt y,
                bkcom t
            where
                a.eve = z.eve
                and a.ave = z.ave
                and z.eve = y.eve
                and a.ave = y.ave
                and y.ncp = t.ncp
                and t.sde < 0
        ),
        0
    ) * nvl(
        (
            select
                tx.tind
            from
                bktau tx
            where
                tx.dev = a.dev
                and dco =(
                    select
                        max(dco)
                    from
                        bktau
                    where
                        dco <= to_date(:DATE_EXTRACT, 'DD/MM/YYYY')
                )
        ),
        1
    ) "IMPAYES_EN_GNF",
    NVL(
        (
            select
                to_char(min(e.dva), 'DD/MM/YYYY')
            from
                bkechprt e,
                bkinipeprt i,
                bkdosprt d
            where
                a.eve = d.eve
                and a.ave = d.ave
                and d.eve = e.eve
                and d.ave = e.ave
                and e.eve = i.eve
                and e.ave = i.ave
                and e.num = i.num
                and e.dva <= to_date(:DATE_EXTRACT, 'DD/MM/YYYY')
                and i.darr_ini >= to_date(:DATE_EXTRACT, 'DD/MM/YYYY')
        ),
        (
            select
                to_char(min(e.dva), 'DD/MM/YYYY')
            from
                bkechprt e,
                bkdosprt d -- bkinipeprt i ,
            where
                a.eve = d.eve
                and a.ave = d.ave
                and d.eve = e.eve
                and d.ave = e.ave
                and e.ctr = '7'
                and e.dva <= to_date(:DATE_EXTRACT, 'DD/MM/YYYY')
        )
    ) "DATE_PREMIER_IMP",
    NVL(
        (
            select
                to_char(max(e.dva), 'DD/MM/YYYY')
            from
                bkechprt e,
                bkinipeprt i,
                bkdosprt d
            where
                a.eve = d.eve
                and a.ave = d.ave
                and d.eve = e.eve
                and d.ave = e.ave
                and e.eve = i.eve
                and e.ave = i.ave
                and e.num = i.num
                and e.dva <= to_date(:DATE_EXTRACT, 'DD/MM/YYYY')
                and i.darr_ini >= to_date(:DATE_EXTRACT, 'DD/MM/YYYY')
        ),
        (
            select
                to_char(max(e.dva), 'DD/MM/YYYY')
            from
                bkechprt e,
                bkdosprt d -- bkinipeprt i ,
            where
                a.eve = d.eve
                and a.ave = d.ave
                and d.eve = e.eve
                and d.ave = e.ave
                and e.ctr = '7'
                and e.dva <= to_date(:DATE_EXTRACT, 'DD/MM/YYYY')
        )
    ) "DATE_DERNIER_IMP",
    (
        select
            COUNT(*)
        from
            bkinipeprt i,
            bkechprt ech
        where
            ech.eve = a.eve
            and ech.ave = a.ave
            and ech.eve = i.eve
            and ech.ave = i.ave
            and ech.num = i.num
            and ech.dva <= to_date(:DATE_EXTRACT, 'DD/MM/YY')
            and i.darr_ini >= to_date(:DATE_EXTRACT, 'DD/MM/YY')
    ) "NB_IMPAYE",
    to_char(a.dmep, 'DD/MM/YYYY') "DATE DE MISE EN PLACE",
    to_char(a.dpec, 'DD/MM/YYYY') "DATE PREMIERE ECHEANCE",
    to_char(a.ddec, 'DD/MM/YYYY') "DATE DERNIERE ECHEANCE",
    Decode(
        per_cap,
        1,
        'M',
        2,
        'M',
        3,
        'T',
        4,
        'M',
        5,
        'M',
        6,
        'S',
        7,
        'M',
        8,
        'M',
        9,
        'M',
        10,
        'M',
        11,
        'M',
        12,
        'A',
        'N'
    ) "PERIODICITE",
    NBE "NOMBRE_ECHEANCES",
    a.tau_int "TAUX_INTERET",
    a.teg "TAUX_EFFECTIF",
    (
        select
            max(nom)
        from
            bkgestionnaire
        where
            ges = c.ges
    ) "GESTIONNAIRE"
from
    bkdosprt a,
    bktyprt b,
    bkcli c,
    bkcptprt e
where
    a.eve || a.ave != '0000010'
    and --OTG UNIQUEMENT
    a.typ = b.typ
    and a.cli = c.cli
    and a.eve || a.ave || a.age = e.eve || e.ave || e.age
    and e.nat = '004'
    and a.dmep <= to_DATE(:DATE_EXTRACT, 'DD/MM/YYYY') ---Prise en compte des dossier dont ech ance sup   la date extract et echus non soldes
    and (
        ---Prise en compte des dossier dont ech ance sup
        (a.ddec >= to_DATE(:DATE_EXTRACT, 'DD/MM/YYYY'))
        or --date extract et echus non soldes
        (
            exists (
                select
                    1
                from
                    bkinipeprt i
                where
                    i.eve = a.eve
                    and i.ave = a.ave
                    and i.darr_ini >= to_date(:DATE_EXTRACT, 'DD/MM/YYYY')
            )
        )
    )
    and a.eta = 'VA'
    and mdb != 0
    and not exists (
        select
            1
        from
            bktomprt r
        where
            r.eve || r.ave = a.eve || a.ave
            and r.dou < to_DATE(:DATE_EXTRACT, 'DD/MM/YYYY')
    )