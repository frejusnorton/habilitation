
Create table ora_datarisk as
select distinct
(select decode(trim(lib2),
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
) FILIALE,
bkcli.age,bkcli.cli,nomrest  ,bkcli.seg codseg,(select lib1 from bknom where ctab='188' and cacc=bkcli.seg) seg ,
(select lib1 from bknom where ctab='043' and cacc=bkcli.qua) CotationClient,
(select max(nom) from bkgestionnaire where ges=bkcli.ges) GEST ,bkcli.sec codesectact,
(select lib1 from bknom where ctab='071' and cacc=bkcli.sec) sectact,
bkcli.catn codecatn,
(select lib1 from bknom where ctab='042' and cacc=bkcli.catn) libcatn
from bkcli  
##
Alter table ora_datarisk
add DATE_EXTRACT date
add SLDCPTCOURT numeric default 0
add sldescomp numeric default 0
add cct numeric default 0
add cmt numeric default 0
add clt numeric default 0
add cct_rest numeric default 0
add cmt_rest numeric default 0
add clt_rest numeric default 0
add creanratt numeric default 0
add mntimp numeric default 0
add mntdout numeric default 0
add CREDOC numeric default 0
add CAUTIONS numeric default 0
add HB_DOUTEUX numeric default 0
add AUTRES_ENG_FINANCEMENTS numeric default 0
add engsign numeric default 0
add surreel numeric default 0
add autresur numeric default 0
add Titres numeric default 0
add PIB numeric default 0
add cptcred numeric default 0
add prov numeric default 0
add prov_HB numeric default 0
add CREDITDIR numeric default 0
add TOTENG numeric default 0
add SDECV numeric default 0
add primary key(cli)

##

update ora_datarisk set  DATE_EXTRACT=TO_DATE(:DATE_EXTRACT,'DD/MM/YYYY')

##
delete from ora_datarisk where cli not in (select distinct cli from bksld where dco=TO_DATE(:DATE_EXTRACT,'DD/MM/YYYY')
and ((bksld.cha like '2511%' and sdecv<0) or bksld.cha like '201%' or bksld.cha like '202%'
or bksld.cha like '203%' or bksld.cha like '204%' or bksld.cha like '29%' or bksld.cha like '90%'
or bksld.cha like '91%' or bksld.cha like '99%' or bksld.cha like '30%' or bksld.cha like '13%' or bksld.cha like '512%' ) and sdecv<>0)
##
 insert into ora_datarisk (filiale,cli,nomrest,SDECV) select filiale,cli,nomrest,SDECV from (select (select decode(trim(lib2),
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
) filiale, concat('CHA', a.cha) as cli, max(b.lib) as nomrest, sum(a.sdecv) as SDECV from bksld a, bkchap b where a.dco=(select max(DATE_EXTRACT) from ora_datarisk)  and a.cli like ' %' and a.sdecv <>0 and b.cha=a.cha
and ((a.cha like '2511%' and a.sdecv<0) or a.cha like '201%' or a.cha like '202%'
or a.cha like '203%' or a.cha like '204%' or a.cha like '29%' or a.cha like '90%'
or a.cha like '901%' or a.cha like '903%' or a.cha like '911%' or a.cha like '913%' or a.cha like '99%' or a.cha like '99%' or a.cha like '30%' or a.cha like
'13%' or
a.cha like '512%') and a.cha not like '903100%' and a.cha not like '9999%' and a.sdecv<>0  group by a.cha ) A

##
update ora_datarisk set DATE_EXTRACT=(select max (DATE_EXTRACT) from ora_datarisk) where DATE_EXTRACT is null


##

update ora_datarisk set SLDCPTCOURT=
nvl((select sum(sdecv) from bksld
where bksld.dco=ora_datarisk.DATE_EXTRACT and bksld.cli=ora_datarisk.cli /* and bksld.age=ora_datarisk.age */ and bksld.cha like ('2511%') and bksld.cha!='251104'
and bksld.sde <0),0)
where cli in (select distinct cli from bksld where
(bksld.cha like ('2511%') and bksld.cha!='251104') and sdecv<0 and dco=(select max(DATE_EXTRACT) from ora_datarisk))

##
update ora_datarisk set sldescomp=
nvl((select sum(sdecv) from bksld where bksld.dco=ora_datarisk.DATE_EXTRACT and bksld.cli=ora_datarisk.cli
and (bksld.cha like '20111%' or bksld.cha like '20121%')),0)
where cli in (select distinct cli from bksld where
(bksld.cha like '20111%' or bksld.cha like '20121%') and sdecv<>0 and dco=(select max(DATE_EXTRACT) from ora_datarisk))

##
update ora_datarisk set cct=
nvl((select sum(sdecv) from bksld
where bksld.dco=ora_datarisk.DATE_EXTRACT and bksld.cli=ora_datarisk.cli /* and bksld.age=ora_datarisk.age */
and bksld.cha like '202%'  and bksld.cha not like '20213%' and bksld.cha not like '20217%' and
bksld.cha not like '20223%' and bksld.cha not like '20227%' and bksld.cha not like '20228%' and bksld.cha not like '20233%'
and bksld.cha not like '20237%' and bksld.cha not like '20247%' and bksld.cha not like '20257%'),0)
where cli in (select distinct cli from bksld where
(bksld.cha like '202%'  and bksld.cha not like '20213%' and bksld.cha not like '20217%' and
bksld.cha not like '20223%' and bksld.cha not like '20227%' and bksld.cha not like '20228%' and bksld.cha not like '20233%'
and bksld.cha not like '20237%' and bksld.cha not like '20247%' and bksld.cha not like '20257%') and sdecv<>0 and dco=(select max(DATE_EXTRACT) from ora_datarisk))

##
update ora_datarisk set cmt=
nvl((select sum(sdecv) from bksld
where bksld.dco=ora_datarisk.DATE_EXTRACT and bksld.cli=ora_datarisk.cli /* and bksld.age=ora_datarisk.age */
and bksld.cha like '203%' and bksld.cha not like '2033%' and bksld.cha not like '2037%' and bksld.cha not like '2038%'),0)
where cli in (select distinct cli from bksld where
(bksld.cha like '203%' and bksld.cha not like '2033%' and bksld.cha not like '2037%' and bksld.cha not like '2038%') and dco=(select max(DATE_EXTRACT) from ora_datarisk))

##
update ora_datarisk set clt =
nvl((select sum(sdecv) from bksld
where bksld.dco=ora_datarisk.DATE_EXTRACT and bksld.cli=ora_datarisk.cli /* and bksld.age=ora_datarisk.age */
and bksld.cha like '204%' and bksld.cha not like '2043%' and bksld.cha not like '2047%' and bksld.cha not like '2048%'),0)
where cli in (select distinct cli from bksld where
(bksld.cha like '204%' and bksld.cha not like '2043%' and bksld.cha not like '2047%' and bksld.cha not like '2048%') and sdecv<>0 and dco=(select max(DATE_EXTRACT) from ora_datarisk))


##

update ora_datarisk set cct_rest=
nvl((select sum(sdecv) from bksld
where bksld.dco=ora_datarisk.DATE_EXTRACT and bksld.cli=ora_datarisk.cli /* and bksld.age=ora_datarisk.age */
and bksld.cha in('291001','291002')),0)
where cli in (select distinct cli from bksld where
(bksld.cha in('291001','291002')) and sdecv<>0 and dco=(select max(DATE_EXTRACT) from ora_datarisk))


##

update ora_datarisk set cmt_rest=
nvl((select sum(sdecv) from bksld
where bksld.dco=ora_datarisk.DATE_EXTRACT and bksld.cli=ora_datarisk.cli /* and bksld.age=ora_datarisk.age */
and bksld.cha in('291004','291005')),0)
where cli in (select distinct cli from bksld where
(bksld.cha in('291004','291005')) and dco=(select max(DATE_EXTRACT) from ora_datarisk))


##

update ora_datarisk set clt_rest =
nvl((select sum(sdecv) from bksld
where bksld.dco=ora_datarisk.DATE_EXTRACT and bksld.cli=ora_datarisk.cli /* and bksld.age=ora_datarisk.age */
and bksld.cha in('291006','291007')),0)
where cli in (select distinct cli from bksld where
(bksld.cha in('291006','291007')) and sdecv<>0 and dco=(select max(DATE_EXTRACT) from ora_datarisk))


##

update ora_datarisk set creanratt=
nvl((select sum(sdecv) from bksld
where bksld.dco=ora_datarisk.DATE_EXTRACT and bksld.cli=ora_datarisk.cli /* and bksld.age=ora_datarisk.age */
 and( bksld.cha  like '20117%' or bksld.cha  like '20127%' or bksld.cha  like '20217%' or
 bksld.cha  like '20227%' or bksld.cha  like '20228%' or bksld.cha  like '20237%'
 or bksld.cha  like '20247%' or bksld.cha  like '20257%' or bksld.cha  like '2037%' or bksld.cha  like '2038%'
 or bksld.cha  like '2047%' or bksld.cha  like '2048%' or bksld.cha  like '2917%')),0)
where cli in (select distinct cli from bksld where
( bksld.cha  like '20117%' or bksld.cha  like '20127%' or bksld.cha  like '20217%' or
 bksld.cha  like '20227%' or bksld.cha  like '20228%' or bksld.cha  like '20237%'
 or bksld.cha  like '20247%' or bksld.cha  like '20257%' or bksld.cha  like '2037%' or bksld.cha  like '2038%'
 or bksld.cha  like '2047%' or bksld.cha  like '2048%' or bksld.cha  like '2917%') and sdecv<>0 and dco=(select max(DATE_EXTRACT) from ora_datarisk))


##

update ora_datarisk set mntimp=
nvl((select sum(sdecv) from bksld
where bksld.dco=ora_datarisk.DATE_EXTRACT and bksld.cli=ora_datarisk.cli /* and bksld.age=ora_datarisk.age */and
(bksld.cha like '20113%' or bksld.cha like '20123%' or bksld.cha like '20213%' or bksld.cha like '20223%' or bksld.cha like '20233%' or
bksld.cha like '2033%' or bksld.cha like '2043%' or bksld.cha like '2913%' or bksld.cha like '2915%' or (bksld.cha like '251104%' and sdecv<0))),0)
where cli in (select distinct cli from bksld where
(bksld.cha like '20113%' or bksld.cha like '20123%' or bksld.cha like '20213%' or bksld.cha like '20223%' or bksld.cha like '20233%' or
bksld.cha like '2033%' or bksld.cha like '2043%' or bksld.cha like '2913%' or bksld.cha like '2915%' or bksld.cha like '251104%') and sdecv<>0 and dco=(select max(DATE_EXTRACT) from ora_datarisk))


##

update ora_datarisk set mntdout=
nvl((select sum(sdecv) from bksld
where bksld.dco=ora_datarisk.DATE_EXTRACT and bksld.cli=ora_datarisk.cli /* and bksld.age=ora_datarisk.age */
and (bksld.cha like '292%' or bksld.cha like '293%')),0)
where cli in (select distinct cli from bksld where
(bksld.cha like '292%' or bksld.cha like '293%') and sdecv<>0 and dco=(select max(DATE_EXTRACT) from ora_datarisk))


##

update ora_datarisk set CREDOC=
nvl((select sum(sdecv) from bksld
where bksld.dco=ora_datarisk.DATE_EXTRACT and bksld.cli=ora_datarisk.cli /* and bksld.age=ora_datarisk.age */
and ( bksld.cha like '903%' or bksld.cha like '911%') and bksld.cha not like '903100%' and bksld.cha not like '9036%'),0)
where cli in (select distinct cli from bksld where
(( bksld.cha like '903%' or bksld.cha like '911%') and bksld.cha not like '903100%' and bksld.cha not like '9036%') and sdecv<>0 and dco=(select max(DATE_EXTRACT) from ora_datarisk))


##
update ora_datarisk set CAUTIONS=
nvl((select sum(sdecv) from bksld
where bksld.dco=ora_datarisk.DATE_EXTRACT and bksld.cli=ora_datarisk.cli /* and bksld.age=ora_datarisk.age */
and bksld.cha like '913%'),0)
where cli in (select distinct cli from bksld where
(bksld.cha like '913%') and sdecv<>0 and dco=(select max(DATE_EXTRACT) from ora_datarisk))


##
update ora_datarisk set HB_DOUTEUX=
nvl((select sum(sdecv) from bksld
where bksld.dco=ora_datarisk.DATE_EXTRACT and bksld.cli=ora_datarisk.cli /* and bksld.age=ora_datarisk.age */
and bksld.cha like '99%' and bksld.cha not like '9999%'),0)
where cli in (select distinct cli from bksld where
(bksld.cha like '99%' and bksld.cha not like '9999%') and sdecv<>0 and dco=(select max(DATE_EXTRACT) from ora_datarisk))


##
update ora_datarisk set AUTRES_ENG_FINANCEMENTS=
nvl((select sum(sdecv) from bksld
where bksld.dco=ora_datarisk.DATE_EXTRACT and bksld.cli=ora_datarisk.cli /* and bksld.age=ora_datarisk.age */
and (bksld.cha like '901%' or bksld.cha like '903100%' or bksld.cha like '9036%')),0)
where cli in (select distinct cli from bksld where
(bksld.cha like '901%' or bksld.cha like '903100%' or bksld.cha like '9036%') and sdecv<>0 and dco=(select max(DATE_EXTRACT) from ora_datarisk))


##

update ora_datarisk set cptcred=
nvl((select sum(sdecv) from bksld
where bksld.dco=ora_datarisk.DATE_EXTRACT and bksld.cli=ora_datarisk.cli/*and bksld.age=ora_datarisk.age */
and (bksld.cha like '25%'or bksld.cha like '1%')
and bksld.sdecv >0),0)
where cli in (select distinct cli from bksld where
(bksld.cha like '25%'or bksld.cha like '1%') and sdecv>0 and dco=(select max(DATE_EXTRACT) from ora_datarisk))


##
update ora_datarisk set Titres=
nvl((select sum(sdecv) from bksld
where bksld.dco=ora_datarisk.DATE_EXTRACT and bksld.cli=ora_datarisk.cli /* and bksld.age=ora_datarisk.age */
and bksld.cha like '30%'),0)
where cli in (select distinct cli from bksld where
(bksld.cha like '30%') and sdecv<>0 and dco=(select max(DATE_EXTRACT) from ora_datarisk))


##
update ora_datarisk set PIB=
nvl((select sum(sdecv) from bksld
where bksld.dco=ora_datarisk.DATE_EXTRACT and bksld.cli=ora_datarisk.cli /* and bksld.age=ora_datarisk.age */
and bksld.cha like '13%'),0)
where cli in (select distinct cli from bksld where
(bksld.cha like '13%') and dco=(select max(DATE_EXTRACT) from ora_datarisk))


##
update ora_datarisk set prov=
nvl((select sum(sdecv) from bksld
where bksld.dco=ora_datarisk.DATE_EXTRACT and bksld.cli=ora_datarisk.cli /* and bksld.age=ora_datarisk.age */
and bksld.cha like '299%'),0)
where cli in (select distinct cli from bksld where
(bksld.cha like '299%') and sdecv<>0 and dco=(select max(DATE_EXTRACT) from ora_datarisk))


##
update ora_datarisk set prov_HB=
nvl((select sum(sdecv) from bksld
where bksld.dco=ora_datarisk.DATE_EXTRACT and bksld.cli=ora_datarisk.cli /* and bksld.age=ora_datarisk.age */
and bksld.cha like '512%'),0)
where cli in (select distinct cli from bksld where
(bksld.cha like '512%') and sdecv<>0 and dco=(select max(DATE_EXTRACT) from ora_datarisk))


##
update ora_datarisk set SLDCPTCOURT=SDECV where cli like 'CHA2511%'


##
update ora_datarisk set sldescomp=SDECV where cli like 'CHA20111%' or cli like 'CHA20121%'


##
update ora_datarisk set cct=SDECV where  cli like 'CHA202%' and cli not like 'CHA20213%' and cli not like 'CHA20217%' and
cli not like 'CHA20223%' and cli not like 'CHA20227%' and cli not like 'CHA20228%' and cli not like 'CHA20233%'
and cli not like 'CHA20237%' and cli not like 'CHA20247%' and cli not like 'CHA20257%'


##
update ora_datarisk set cmt=SDECV where cli like 'CHA203%' and cli not like 'CHA2033%' and cli not like 'CHA2037%' and cli not like 'CHA2038%' 


##
update ora_datarisk set clt =SDECV where cli like 'CHA204%' and cli not like 'CHA2043%' and cli not like 'CHA2047%' and cli not like 'CHA2048%' 


##
update ora_datarisk set cct_rest=SDECV where cli in('CHA291001','CHA291002') 


##
update ora_datarisk set cmt_rest=SDECV where cli in('CHA291004','CHA291005') 


##
update ora_datarisk set clt_rest=SDECV where cli in('CHA291006','CHA291007') 


##
update ora_datarisk set creanratt=SDECV where ( cli  like 'CHA20117%' or cli  like 'CHA20127%' or cli  like 'CHA20217%' or
 cli  like 'CHA20227%' or cli like 'CHA20228%' or cli like 'CHA20237%'
 or cli  like 'CHA20247%' or cli  like 'CHA20257%' or cli like 'CHA2037%' or cli like 'CHA2038%'
 or cli like 'CHA2047%' or cli  like 'CHA2048%' or cli like 'CHA2917%') 


##
update ora_datarisk set mntimp=SDECV where(cli like 'CHA20113%' or cli like 'CHA20123%' or cli like 'CHA20213%' or cli like 'CHA20223%' or cli like 'CHA20233%' or
cli like 'CHA2033%' or cli like 'CHA2043%' or cli like 'CHA2913%' or cli like 'CHA2915%' or cli like 'CHA251104%')


##
update ora_datarisk set mntdout=SDECV where (cli like 'CHA292%' or cli like 'CHA293%')


##
update ora_datarisk set CREDOC=SDECV where ( cli like 'CHA903%' or cli like 'CHA911%') and cli not like 'CHA903100%' and cli not like 'CHA9036%' 


##
update ora_datarisk set CAUTIONS=SDECV where cli like 'CHA913%'


##
update ora_datarisk set HB_DOUTEUX=SDECV where cli like 'CHA99%' and cli not like 'CHA9999%'

##
update ora_datarisk set AUTRES_ENG_FINANCEMENTS=SDECV where(cli like 'CHA901%' or cli like 'CHA903100%' or cli like 'CHA9036%') 

##
update ora_datarisk set Titres=SDECV where cli like 'CHA30%'

##
update ora_datarisk set PIB=SDECV where cli like 'CHA13%'

##
update ora_datarisk set prov=SDECV where cli like 'CHA299%'

##
update ora_datarisk set prov_HB=SDECV where cli like 'CHA512%'

##
update ora_datarisk set CREDITDIR=SLDCPTCOURT+sldescomp+CCT+CMT+CLT+cct_rest+cmt_rest+clt_rest+creanratt+mntimp+mntdout

##
update ora_datarisk set engsign=CREDOC+CAUTIONS+HB_DOUTEUX

##
update ora_datarisk set TOTENG=CREDITDIR+engsign
