CREATE OR REPLACE FUNCTION ora_getdoucpt(agence CHAR, devise CHAR, compte CHAR) RETURN DATE
is
v_dou DATE;
Begin
Select dou into v_dou From bkcom Where age = agence and dev = devise and ncp = compte;
Return v_dou;
End ora_getdoucpt;
##

--DATE PREMIER IMPAYES
CREATE OR REPLACE FUNCTION ora_gedatePimp(c_age IN bkdosprt.age%TYPE ,c_eve IN bkdosprt.eve%TYPE,c_ave IN bkdosprt.ave%TYPE,DATE_EXT IN bkechprt.dva%TYPE )
RETURN bkechprt.dva%TYPE
IS
v_dva bkechprt.dva%TYPE;
BEGIN
select min(ech.dva) into v_dva from bkinipeprt i,bkechprt ech
where ech.age=c_age and ech.eve=c_eve and ech.ave=c_ave
and ech.age=i.age and ech.eve=i.eve and ech.ave=i.ave and ech.num=i.num and ech.dva<=to_date(DATE_EXT,'DD/MM/YY') and i.darr_ini>=to_date(DATE_EXT,'DD/MM/YY');
RETURN v_dva;
END ora_gedatePimp;


##

--DATE DERNIER IMPAYES
CREATE OR REPLACE FUNCTION ora_gedateDimp(c_age IN bkdosprt.age%TYPE ,c_eve IN bkdosprt.eve%TYPE,c_ave IN bkdosprt.ave%TYPE,DATE_EXT IN bkechprt.dva%TYPE )
RETURN bkechprt.dva%TYPE
IS
v_dva bkechprt.dva%TYPE;
BEGIN
select max(ech.dva) into v_dva from bkinipeprt i,bkechprt ech
where ech.age=c_age and ech.eve=c_eve and ech.ave=c_ave
and ech.age=i.age and ech.eve=i.eve and ech.ave=i.ave and ech.num=i.num and ech.dva<=to_date(DATE_EXT,'DD/MM/YY') and i.darr_ini>=to_date(DATE_EXT,'DD/MM/YY');
RETURN v_dva;
END ora_gedateDimp;

##


CREATE OR REPLACE FUNCTION ora_getdatedecrec_cli(c_age IN bkcom.age%TYPE , c_cli IN bkcom.cli%TYPE, chadecrec CHAR,premdern CHAR,DATE_EXT IN BKHCCOM.dchgt%TYPE)
RETURN BKHCCOM.DCHGT%TYPE
is
v_date DATE;
---valeur de premdern : 'P' ==> premi�re declassement/reclassement et 'D'==>deniere fois premi�re declassement/reclassement
---valeur de chadecrec : pour declassement mettre chapitre douteux et chapitre sain pour reclassement
Begin
   case when premdern='P'  then
             Select min(dchgt) into v_date from BKHCCOM a, BKCOM B Where a.age=b.age and a.dev=b.dev and a.ncp=b.ncp and b.age=c_age and b.cli=c_cli and nocha like chadecrec||'%' and dchgt<=to_date(DATE_EXT,'DD/MM/YY');
        else
             Select max(dchgt) into v_date from BKHCCOM a, BKCOM B Where a.age=b.age and a.dev=b.dev and a.ncp=b.ncp and b.age=c_age and b.cli=c_cli and nocha like chadecrec||'%' and dchgt<=to_date(DATE_EXT,'DD/MM/YY');
   end case  ;
Return v_date;
End ora_getdatedecrec_cli;

##


--NOMBRE IMPAYES
CREATE OR REPLACE FUNCTION ora_nbre_imp(c_age IN bkdosprt.age%TYPE ,c_eve IN bkdosprt.eve%TYPE,c_ave IN bkdosprt.ave%TYPE,DATE_EXT IN bkechprt.dva%TYPE )
RETURN bkechprt.num%TYPE
IS
v_nb bkechprt.num%TYPE;
BEGIN
select COUNT(*) into v_nb from bkinipeprt i,bkechprt ech
where ech.age=c_age and ech.eve=c_eve and ech.ave=c_ave
and ech.age=i.age and ech.eve=i.eve and ech.ave=i.ave and ech.num=i.num and ech.dva<=to_date(DATE_EXT,'DD/MM/YY') and i.darr_ini>=to_date(DATE_EXT,'DD/MM/YY');
RETURN v_nb;
END ora_nbre_imp;

##


CREATE OR REPLACE FUNCTION ora_gedatePimp_ncp( c_compte IN bkcom.ncp%TYPE ,DATE_EXT IN bkechprt.dva%TYPE )
RETURN bkechprt.dva%TYPE
IS
v_dva bkechprt.dva%TYPE;
BEGIN
select min(ech.dva) into v_dva from bkinipeprt i,bkechprt ech,bkcptprt p
where  P.ncp=c_compte and  p.nat in ('006','008')
and ech.age=p.age and ech.eve=p.eve and ech.ave=p.ave
and ech.age=i.age and ech.eve=i.eve and ech.ave=i.ave and ech.num=i.num and ech.dva<=to_date(DATE_EXT,'DD/MM/YY') and i.darr_ini>=to_date(DATE_EXT,'DD/MM/YY');
RETURN v_dva;
END ora_gedatePimp_ncp;

##

-----MONTANT IMPAYE
CREATE OR REPLACE FUNCTION ora_getencoursimp_map(c_age IN bkdosprt.age%TYPE ,c_eve IN bkdosprt.eve%TYPE,c_ave IN bkdosprt.ave%TYPE,DATE_EXT IN bkechprt.dva%TYPE )
RETURN bkechprt.res%TYPE
IS
v_resimp bkechprt.res%TYPE;
BEGIN
select (sum(e.amo_imp)+sum(e.int_imp)+sum(e.tin_imp)
--+sum(e.ini_imp)+sum(e.tini_imp)
) into  v_resimp
from bkechprt e, bkinipeprt i
where  e.age=c_age and e.eve=c_eve and e.ave=c_ave
and e.age=i.age and e.eve=i.eve and e.ave=i.ave and e.num=i.num
and e.dva<=to_date(DATE_EXT,'DD/MM/YY')and i.darr_ini>=to_date(DATE_EXT,'DD/MM/YY') ;
RETURN v_resimp;
END ora_getencoursimp_map;

##

CREATE OR REPLACE FUNCTION ora_getdatedecrec( c_cli IN bkcom.cli%TYPE,chacourant CHAR,chadecrec CHAR,premdern CHAR)
RETURN BKHCCOM.DCHGT%TYPE
is
v_date DATE;
---valeur de premdern : 'P' ==> premi�re declassement/reclassement et 'D'==>deniere fois premi�re declassement/reclassement
---valeur de chadecrec : pour declassement mettre chapitre douteux et chapitre sain pour reclassement
Begin
   case when premdern='P'  then
             Select min(dchgt) into v_date from BKHCCOM a,bkcom c
             Where a.age=c.age and a.dev=c.dev and a.ncp=c.ncp and c.cli=c_cli and a.ancha like  chacourant||'%' and nocha like chadecrec||'%';
        else
             Select max(dchgt) into v_date from BKHCCOM a ,bkcom c
             Where  a.age=c.age and a.dev=c.dev and a.ncp=c.ncp and c.cli=c_cli and a.ancha like  chacourant||'%' and nocha like chadecrec||'%';
   end case  ;
Return v_date;
End ora_getdatedecrec;

##

CREATE OR REPLACE FUNCTION ora_getdatedecrec_ncp(c_age IN bkcom.age%TYPE , c_dev IN bkcom.dev%TYPE, c_ncp IN bkcom.ncp%TYPE,chadecrec CHAR,premdern CHAR)
RETURN BKHCCOM.DCHGT%TYPE
is
v_date DATE;
---valeur de premdern : 'P' ==> premi�re declassement/reclassement et 'D'==>deniere fois premi�re declassement/reclassement
---valeur de chadecrec : pour declassement mettre chapitre douteux et chapitre sain pour reclassement
Begin
   case when premdern='P'  then
             Select min(dchgt) into v_date from BKHCCOM a Where a.age=c_age and a.dev=c_dev and a.ncp=c_ncp and nocha like chadecrec||'%';
        else
             Select max(dchgt) into v_date from BKHCCOM a Where a.age=c_age and a.dev=c_dev and a.ncp=c_ncp and nocha like chadecrec||'%';
   end case  ;
Return v_date;
End ora_getdatedecrec_ncp;

##


CREATE OR REPLACE FUNCTION ora_getdatedecrec_ncp_courant(c_age IN bkcom.age%TYPE , c_dev IN bkcom.dev%TYPE, c_ncp IN bkcom.ncp%TYPE,chacourant CHAR,chadecrec CHAR,premdern CHAR)
RETURN BKHCCOM.DCHGT%TYPE
is
v_date DATE;
---valeur de premdern : 'P' ==> premi�re declassement/reclassement et 'D'==>deniere fois premi�re declassement/reclassement
---valeur de chadecrec : pour declassement mettre chapitre douteux et chapitre sain pour reclassement
Begin
   case when premdern='P'  then
             Select min(dchgt) into v_date from BKHCCOM a Where a.age=c_age and a.dev=c_dev and a.ncp=c_ncp and a.ancha like  chacourant||'%' and nocha like chadecrec||'%';
        else
             Select max(dchgt) into v_date from BKHCCOM a Where a.age=c_age and a.dev=c_dev and a.ncp=c_ncp and a.ancha like  chacourant||'%' and nocha like chadecrec||'%';
   end case  ;
Return v_date;
End ora_getdatedecrec_ncp_courant;

##


CREATE OR REPLACE FUNCTION ora_getdatechangcha(c_cli IN bkcom.cli%TYPE,chadecrec CHAR,premdern CHAR,DATE_EXT IN BKHCCOM.dchgt%TYPE )
RETURN BKHCCOM.DCHGT%TYPE
is
v_date DATE;
---valeur de premdern : 'P' ==> premi�re declassement/reclassement et 'D'==>deniere fois premi�re declassement/reclassement
---valeur de chadecrec : pour declassement mettre chapitre douteux et chapitre sain pour reclassement
Begin
   case when premdern='P'  then
             -- Select min(dchgt) into v_date from BKHCCOM a Where a.age=c_age and a.dev=c_dev and a.ncp=c_ncp and nocha like chadecrec||'%' and dchgt>=to_date(DATE_EXT,'DD/MM/YY')
             Select min(dchgt) into v_date from BKHCCOM a,BKCOM c
             Where  a.age=c.age and a.dev=c.dev and a.ncp=c.ncp and a.nocha like chadecrec||'%'
                    and dchgt<=to_date(DATE_EXT,'DD/MM/YY')
                    and c.cli=c_cli;
        else
             --Select max(dchgt) into v_date from BKHCCOM a Where a.age=c_age and a.dev=c_dev and a.ncp=c_ncp and nocha like chadecrec||'%' and dchgt>=to_date(DATE_EXT,'DD/MM/YY');
              Select max(dchgt) into v_date from BKHCCOM a,BKCOM c
                Where  a.age=c.age and a.dev=c.dev and a.ncp=c.ncp and a.nocha like chadecrec||'%'
                        and dchgt<=to_date(DATE_EXT,'DD/MM/YY')
                        and c.cli=c_cli;
   end case  ;
Return v_date;
End ora_getdatechangcha;

##


/* Proc�dure*/
-----------------------------------




CREATE OR REPLACE FUNCTION ora_date_debit(c_sde IN bksld.sde%TYPE,c_age IN bkhis.age%TYPE ,c_ncp IN bkhis.ncp%TYPE,c_dco in bkhis.ncp%TYPE)
RETURN bkhis.dco%TYPE
IS
v_dco bkhis.dco%TYPE;
BEGIN
   select  min(t.dco) into v_dco from ( select  dco,sum(mon) as mon ,max(sde) as sde, (max(sde) + sum(mon)) as SD  from (select
dco,
CASE
    WHEN sen='D'
        THEN -mon
    ELSE
        mon
  END Mon,
c_sde-sum(CASE
    WHEN sen='D'
        THEN -mon
    ELSE
        mon
  END ) over (order by dco desc) SDE
from bkhis where ncp=c_ncp and age=c_age and dco<=c_dco ) t group by dco order by dco desc) t where t.sd<0 and t.dco >
(
select  max(t.dco) from ( select  dco,sum(mon) as mon ,max(sde) as sde, (max(sde) + sum(mon)) as SD  from (select
dco,
CASE
    WHEN sen='D'
        THEN -mon
    ELSE
        mon
  END Mon,
c_sde-sum(CASE
    WHEN sen='D'
        THEN -mon
    ELSE
        mon
  END ) over (order by dco desc) SDE
from bkhis where ncp=c_ncp and age=c_age and dco<=c_dco ) t group by dco order by dco desc) t where t.sd>=0);
 RETURN v_dco;
END ora_date_debit;

##

CREATE OR REPLACE FUNCTION ora_date_dep(c_sde IN bksld.sde%TYPE,c_age IN bkhis.age%TYPE ,c_ncp IN bkhis.ncp%TYPE,c_dco in bkhis.ncp%TYPE,c_aut in numeric)
RETURN bkhis.dco%TYPE
IS
v_dco bkhis.dco%TYPE;
BEGIN
   select  min(t.dco) into v_dco from ( select  dco,sum(mon) as mon ,max(sde) as sde, (max(sde) + sum(mon)) as SD  from (select
dco,
CASE
    WHEN sen='D'
        THEN -mon
    ELSE
        mon
  END Mon,
c_aut+c_sde-sum(CASE
    WHEN sen='D'
        THEN -mon
    ELSE
        mon
  END ) over (order by dco desc) SDE
from bkhis where ncp=c_ncp and age=c_age and dco<=c_dco ) t group by dco order by dco desc) t where t.sd<0 and t.dco >
(
select  max(t.dco) from ( select  dco,sum(mon) as mon ,max(sde) as sde, (max(sde) + sum(mon)) as SD  from (select
dco,
CASE
    WHEN sen='D'
        THEN -mon
    ELSE
        mon
  END Mon,
c_aut+c_sde-sum(CASE
    WHEN sen='D'
        THEN -mon
    ELSE
        mon
  END ) over (order by dco desc) SDE
from bkhis where ncp=c_ncp and age=c_age and dco<=c_dco ) t group by dco order by dco desc) t where t.sd>=0);
 RETURN v_dco;
END ora_date_dep;
##
