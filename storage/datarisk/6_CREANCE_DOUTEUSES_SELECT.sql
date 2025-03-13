--6 Creances DOUTEUSES
select
    (
        select
            Trim(lib1)
        from
            bknom
        where
            cacc = 'BANQUE'
    ) "FILIALE",
    :V_DATE "DATE_DE_REFERENCE",
    CODE_CLIENT "CODE_CLIENT",
    NCP_DOUT "NUM_COMPTE_DOUTEUX",
    NOM "NOM_ET_PRENOMS",
    DATE_OUV_DOUT "DATE_DECLASSEMENT",
    TOTAL_DOUTEUX "MONTANT_ENGAGEMENT",
    TOTAL_DOUTEUX "MONTANT_DOUTEUX",
    TOTAL_PROVISION "MONTANT_DES_PROVISIONS"
FROM
    (
        select
            c.age AGENCE,
            c.cli "CODE_CLIENT",
            c.nomrest "NOM",
            NVL(
                (
                    select
                        sum(s.sdecv) sde
                    from
                        bksld s,
                        bkcom a
                    where
                        s.age = a.age
                        and s.ncp = a.ncp
                        and a.cli = c.cli
                        and substr(a.cha, 1, 3) in ('292', '293')
                        and trim(a.cli) is not null
                        and s.sde != 0
                        and s.dco = to_date(:V_DATE, 'DD/MM/YYYY')
                ),
                0
            ) "TOTAL_DOUTEUX",
            (
                select
                    to_char(max(dou), 'DD/MM/YYYY')
                from
                    bkcom a
                where
                    c.cli = a.cli
                    and substr(a.cha, 1, 3) in ('292', '293')
            ) "DATE_OUV_DOUT",
            NVL(
                (
                    select
                        sum(s.sdecv) sde
                    from
                        bksld s,
                        bkcom a
                    where
                        s.age = a.age
                        and s.ncp = a.ncp
                        and a.cli = c.cli
                        and a.cha like '2992%'
                        and trim(a.cli) is not null
                        and s.sde != 0
                        and s.dco = to_date(:V_DATE, 'DD/MM/YYYY')
                ),
                0
            ) "TOTAL_PROVISION",
            (
                select
                    max(ncp)
                from
                    bkcom a
                where
                    c.cli = a.cli
                    and substr(a.cha, 1, 3) in ('292', '293')
                    and a.cfe = 'N'
                    and a.dou <= to_date(:V_DATE, 'DD/MM/YYYY')
            ) "NCP_DOUT"
        from
            bkcli c
        where
            exists(
                select
                    1
                from
                    bkcom
                where
                    c.cli = bkcom.cli
                    and bkcom.dou <= to_date(:V_DATE, 'DD/MM/YYYY')
                    and (
                        substr(cha, 1, 3) in ('292', '293')
                        or cha like '2992%'
                    )
            )
    )
WHERE
    (abs(TOTAL_DOUTEUX) + abs(TOTAL_PROVISION)) != 0
ORDER BY
    substr(AGENCE, 3, 1),
    TOTAL_DOUTEUX;