SELECT
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
    :DATE_EXTRACT "DATE_DE_REFERENCE",
    s.cha "CHAPITRE",
    c.cli "CODE_CLIENT",
    s.ncp "Num_COMPTE_COURANT",
    c.nomrest "NOM_ET_PRENOMS",
    (
        select
            To_char(max(dco), 'DD/MM/YYYY')
        from
            bkhis h
        where
            h.age = s.age
            and h.ncp = s.ncp
            and h.sen = 'C'
            and h.dco <= to_date(:DATE_EXTRACT, 'DD/MM/YYYY')
    ) "DATE_DERNIER_MVT_CREDIT",
    coalesce(
        (
            select
                To_char(dodb, 'DD/MM/YYYY')
            from
                bkcom
            where
                dodb <= to_date(:DATE_EXTRACT, 'DD/MM/YYYY')
                and bkcom.age = s.age
                and bkcom.ncp = s.ncp
                and bkcom.cli = s.cli
                and bkcom.dev = s.dev
        ),
        To_char(
            ora_date_debit(
                s.sde,
                s.age,
                s.ncp,
                to_date(:DATE_EXTRACT, 'DD/MM/YYYY')
            ),
            'DD/MM/YYYY'
        ),
        (
            select
                To_char(min(dco), 'DD/MM/YYYY')
            from
                bkhis m
            where
                m.age = s.age
                and m.ncp = s.ncp
                and m.sen = 'D'
        )
    ) "DATE_DEBITEUR",
    s.sdecv "SOLDE_COMPTE",
    NVL(
        (
            select
                sum(maut)
            from
                bkautc t
            where
                t.ncp = s.ncp
                and s.cha like '2511%'
                and s.cha != '251104'
                and t.eta in('VA', 'VF')
                and to_date(:DATE_EXTRACT, 'DD/MM/YYYY') <= t.fin
                and ---date dernier debit 
                (
                    (
                        select
                            max(dco)
                        from
                            bkhis h
                        where
                            h.age = s.age
                            and h.ncp = s.ncp
                            and h.sen = 'D'
                            and h.dco <= to_date(:DATE_EXTRACT, 'DD/MM/YYYY')
                    ) between t.debut
                    and t.ech
                )
        ),
        0
    ) "MONTANT_AUTORISATION",
    NVL(
        (
            select
                To_char(max(t.ech), 'DD/MM/YYYY')
            from
                bkautc t
            where
                t.ncp = s.ncp
                and s.cha like '2511%'
                and s.cha != '251104'
                and t.eta in('VA', 'VF')
                and to_date(:DATE_EXTRACT, 'DD/MM/YYYY') <= t.fin
                and ---date dernier debit 
                (
                    (
                        select
                            max(dco)
                        from
                            bkhis h
                        where
                            h.age = s.age
                            and h.ncp = s.ncp
                            and h.sen = 'D'
                            and h.dco <= to_date(:DATE_EXTRACT, 'DD/MM/YYYY')
                    ) between t.debut
                    and t.ech
                )
        ),
        ''
    ) "DATE_ECHEANCE_AUTORISATION",
    case
        when abs(s.sdecv) > NVL(
            (
                select
                    sum(maut)
                from
                    bkautc t
                where
                    t.ncp = s.ncp
                    and s.cha like '2511%'
                    and s.cha != '251104'
                    and t.eta in('VA', 'VF')
                    and to_date(:DATE_EXTRACT, 'DD/MM/YYYY') <= t.fin
                    and ---date dernier debit 
                    (
                        (
                            select
                                max(dco)
                            from
                                bkhis h
                            where
                                h.age = s.age
                                and h.ncp = s.ncp
                                and h.sen = 'D'
                                and h.dco <= to_date(:DATE_EXTRACT, 'DD/MM/YYYY')
                        ) between t.debut
                        and t.ech
                    )
            ),
            0
        ) then s.sdecv + NVL(
            (
                select
                    sum(maut)
                from
                    bkautc t
                where
                    t.ncp = s.ncp
                    and s.cha like '2511%'
                    and s.cha != '251104'
                    and t.eta in('VA', 'VF')
                    and to_date(:DATE_EXTRACT, 'DD/MM/YYYY') <= t.fin
                    and ---date dernier debit 
                    (
                        (
                            select
                                max(dco)
                            from
                                bkhis h
                            where
                                h.age = s.age
                                and h.ncp = s.ncp
                                and h.sen = 'D'
                                and h.dco <= to_date(:DATE_EXTRACT, 'DD/MM/YYYY')
                        ) between t.debut
                        and t.ech
                    )
            ),
            0
        )
        else 0
    END "DEPASSEMENT",
    case
        when NVL(
            (
                select
                    sum(maut)
                from
                    bkautc t
                where
                    t.ncp = s.ncp
                    and s.cha like '2511%'
                    and s.cha != '251104'
                    and t.eta in('VA', 'VF')
                    and to_date(:DATE_EXTRACT, 'DD/MM/YYYY') <= t.fin
                    and ---date dernier debit 
                    (
                        (
                            select
                                max(dco)
                            from
                                bkhis h
                            where
                                h.age = s.age
                                and h.ncp = s.ncp
                                and h.sen = 'D'
                                and h.dco <= to_date(:DATE_EXTRACT, 'DD/MM/YYYY')
                        ) between t.debut
                        and t.ech
                    )
            ),
            0
        ) = 0 then coalesce(
            (
                select
                    To_char(dodb, 'DD/MM/YYYY')
                from
                    bkcom
                where
                    dodb <= to_date(:DATE_EXTRACT, 'DD/MM/YYYY')
                    and bkcom.age = s.age
                    and bkcom.ncp = s.ncp
                    and bkcom.cli = s.cli
                    and bkcom.dev = s.dev
            ),
            To_char(
                ora_date_debit(
                    s.sde,
                    s.age,
                    s.ncp,
                    to_date(:DATE_EXTRACT, 'DD/MM/YYYY')
                ),
                'DD/MM/YYYY'
            ),
            (
                select
                    To_char(min(dco), 'DD/MM/YYYY')
                from
                    bkhis m
                where
                    m.age = s.age
                    and m.ncp = s.ncp
                    and m.sen = 'D'
            )
        )
        when abs(s.sdecv) > NVL(
            (
                select
                    sum(maut)
                from
                    bkautc t
                where
                    t.ncp = s.ncp
                    and s.cha like '2511%'
                    and s.cha != '251104'
                    and t.eta in('VA', 'VF')
                    and to_date(:DATE_EXTRACT, 'DD/MM/YYYY') <= t.fin
                    and ---date dernier debit 
                    (
                        (
                            select
                                max(dco)
                            from
                                bkhis h
                            where
                                h.age = s.age
                                and h.ncp = s.ncp
                                and h.sen = 'D'
                                and h.dco <= to_date(:DATE_EXTRACT, 'DD/MM/YYYY')
                        ) between t.debut
                        and t.ech
                    )
            ),
            0
        ) --then NVL((select To_char(daut,'DD/MM/YYYY')from bkcom  where bkcom.age=s.age and bkcom.ncp=s.ncp and bkcom.cli=s.cli and bkcom.dev=s.dev ),(select To_char(dodb,'DD/MM/YYYY')from bkcom  where  bkcom.age=s.age and bkcom.ncp=s.ncp and bkcom.cli=s.cli and bkcom.dev=s.dev  )) 
        then coalesce(
            (
                select
                    To_char(daut, 'DD/MM/YYYY')
                from
                    bkcom
                where
                    bkcom.age = s.age
                    and bkcom.ncp = s.ncp
                    and bkcom.cli = s.cli
                    and bkcom.dev = s.dev
                    and To_char(daut, 'DD/MM/YYYY') <= to_date(:DATE_EXTRACT, 'DD/MM/YYYY')
            ),
            To_char(
                ora_date_dep(
                    s.sde,
                    s.age,
                    s.ncp,
                    to_date(:DATE_EXTRACT, 'DD/MM/YYYY'),
                    NVL(
                        (
                            select
                                sum(maut)
                            from
                                bkautc t
                            where
                                t.ncp = s.ncp
                                and s.cha like '2511%'
                                and s.cha != '251104'
                                and t.eta in('VA', 'VF')
                                and to_date(:DATE_EXTRACT, 'DD/MM/YYYY') <= t.fin
                                and ---date dernier debit 
                                (
                                    (
                                        select
                                            max(dco)
                                        from
                                            bkhis h
                                        where
                                            h.age = s.age
                                            and h.ncp = s.ncp
                                            and h.sen = 'D'
                                            and h.dco <= to_date(:DATE_EXTRACT, 'DD/MM/YYYY')
                                    ) between t.debut
                                    and t.ech
                                )
                        ),
                        0
                    )
                ),
                'DD/MM/YYYY'
            ),
            (
                select
                    To_char(dodb, 'DD/MM/YYYY')
                from
                    bkcom
                where
                    bkcom.age = s.age
                    and bkcom.ncp = s.ncp
                    and bkcom.cli = s.cli
                    and bkcom.dev = s.dev
                    and To_char(dodb, 'DD/MM/YYYY') <= to_date(:DATE_EXTRACT, 'DD/MM/YYYY')
            ),
            To_char(
                ora_date_debit(
                    s.sde,
                    s.age,
                    s.ncp,
                    to_date(:DATE_EXTRACT, 'DD/MM/YYYY')
                ),
                'DD/MM/YYYY'
            ),
            (
                select
                    To_char(min(dco), 'DD/MM/YYYY')
                from
                    bkhis m
                where
                    m.age = s.age
                    and m.ncp = s.ncp
                    and m.sen = 'D'
            )
        )
        else ''
    END "date_depassement" --NVL((select To_char(daut,'DD/MM/YYYY')from bkcom  where bkcom.ncp=s.ncp and bkcom.cli=s.cli ),' ') "DATE DEPASSEMENT2"
from
    bksld s,
    bkcli c
where
    s.cli = c.cli
    and s.dco = to_date(:DATE_EXTRACT, 'DD/MM/YYYY')
    and s.cha like '2511%'
    and s.cha != '251104'
    and s.sdecv < 0;