
Create table ORA_DATARISK5(
AGENCE varchar2(6),
FILIALE varchar2(35),
DATE_EXTRACT date,
CODE_CLIENT varchar2(6),
CHAPITRE varchar2(6),
NUM_COMPTE varchar2(11),
DEVISE number,
NOM_CLIENT varchar2(75),
CUMUL_AGIOS_6MOIS numeric,
CUMUL_CREIT_6MOIS numeric,
deb6M numeric,
DUREE number,
Primary key(CODE_CLIENT,NUM_COMPTE,DUREE))

##

insert into ORA_DATARISK5
select s.age AGENCE ,(
select decode(trim(lib2),
'280','ORABANK TOGO',
'284','ORABANK BENIN',
'236','ORABANK BURKINA',
'232','ORABANK MALI',
'240','ORABANK NIGER',
'248','ORABANK SENEGAL',
'272','ORABANK CI',
'257','ORABANK GUINEE BISSAU',
'314','ORABANK GABON',
'244','ORABANK TCHAD',
'228','ORABANK MAURITANIE',
'260','ORABANK GUINEE')
from bknom where cacc='BANQUE'
) FILIALE,s.dco,
trim(s.cli) CODE_CLIENT,trim(s.cha) CHAPITRE,s.ncp NUM_COMPTE,s.dev DEVISE,
(select nomrest from bkcli where s.cli=bkcli.cli  ) NOM_CLIENT,
nvl((select sum(decode(sen,'D',mon)) from bkhis
            where bkhis.age=s.age and bkhis.dev=s.dev and bkhis.ncp=s.ncp and s.cha like '2511%' and s.cha !='251104' and bkhis.dco between (s.dco-90) and s.dco
            and bkhis.ope in (select distinct ope  from bkope where lib like'%AGIO%' union select distinct ope from bkcondval where nat='FRASER') ),0)  CUMUL_AGIOS_6MOIS,
nvl((select sum(decode(sen,'C',mon)) from bkhis
            where bkhis.age=s.age and bkhis.dev=s.dev and bkhis.ncp=s.ncp and s.cha like '2511%' and s.cha !='251104'  and bkhis.dco between (s.dco-90) and s.dco),0)  CUMUL_CREIT_6MOIS    ,

nvl((select s.sdecv from bkcom
    where  s.dco=TO_date(:DATE_EXTRACT,'DD/MM/YYYY') and
        s.cli=bkcom.cli  and s.age=bkcom.age  and bkcom.ncp=s.ncp and s.cha like '2511%'  and s.cha !='251104'
        and bkcom.dou<=TO_date(:DATE_EXTRACT,'DD/MM/YYYY')-90 and s.sdecv <0
        and (s.sdecv+nvl((select sum(decode(sen,'D',mon)) from bkhis where bkhis.age=s.age and bkhis.dev=s.dev and bkhis.ncp=s.ncp and s.cha like '2511%'
        and s.cha !='251104'  and bkhis.dco between (s.dco-90) and s.dco),0))<0
        and nvl((select sum(decode(sen,'C',mon)) from bkhis
                    where bkhis.age=s.age and bkhis.dev=s.dev and bkhis.ncp=s.ncp and s.cha like '2511%' and s.cha !='251104'  and  bkhis.dco between (s.dco-90) and s.dco),0)
            <
            nvl((select sum(decode(sen,'D',mon)) from bkhis
                    where bkhis.age=s.age and bkhis.dev=s.dev and bkhis.ncp=s.ncp and s.cha like '2511%' and s.cha !='251104'  and bkhis.dco between (s.dco-90) and s.dco
                    and bkhis.ope in (select distinct ope  from bkope where lib like'%AGIO%' union select distinct ope from bkcondval where nat='FRASER') ),0)
    ),0) deb6M ,
    90 DUREE
from bksld s
where  s.cha like '2511%' and s.cha !='251104'
    and s.dco=TO_date(:DATE_EXTRACT,'DD/MM/YYYY')

    and s.sdecv<0
##
Delete from ORA_DATARISK5 where  ORA_DATARISK5.deb6M=0
##