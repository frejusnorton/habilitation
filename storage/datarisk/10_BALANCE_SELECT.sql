select
    age,
    dev,
    cha,
    cli,
    ncp,
    (
        select
            inti
        from
            dbprod.bkcom c
        where
            c.ncp = s.ncp
            and c.age = s.age
            and c.dev = s.dev
    ) INTI,
    (
        select
            trim(nom) || trim(pre)
        from
            dbprod.bkcli cl
        where
            cl.cli = s.cli
    ) NOMS_CLIENT,
    sde,
    sdecv,
    sdmoy,
    sdmoycv,
    att1,
    (
        select
            Lib1
        from
            dbprod.bknom p
        where
            ctab = '040'
            and cacc = s.att1
    ) "Pays_de_residence",
    att2,
    (
        select
            Lib1
        from
            dbprod.bknom p
        where
            ctab = '042'
            and cacc = s.att2
    ) "Agent_economique",
    att7,
    (
        select
            Lib1
        from
            dbprod.bknom p
        where
            ctab = '071'
            and cacc = s.att7
    ) "Secteur_activite"
from
    dbprod.bksld s
where
    dco = :dtedco
    and sde <> 0;