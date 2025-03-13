

SELECT DISTINCT
    bkdosprt_#DATE_EXTRACT.eve || bkdosprt_#DATE_EXTRACT.ave                                      AS "ContractCode",
    CASE
        WHEN (
            SELECT
                COUNT(*)
            FROM
                bkicli
            WHERE
                    cli = bkcli.cli
                AND vala = 'O'
                AND iden = 'CONSENT'
        ) > 0 THEN
            TRIM(bkcli.cli)
        ELSE
            'BJLOI2020-08' || TRIM(bkcli.cli)
    END                                                                               AS "ConsentCode",
    (
        SELECT
            rtrim(ltrim(lib))
        FROM
            bkage
        WHERE
            TRIM(bkage.age) = TRIM(bkcli.age)
    )                                                                                 AS "Branch",
    CASE
        WHEN bkdosprt_#DATE_EXTRACT.ctr = 9
             AND bkdosprt_#DATE_EXTRACT.eta = 'VA' THEN
            'Closed'
        ELSE
            'Open'
    END                                                                               AS "PhaseOfContract",
    CASE
        WHEN bkdosprt_#DATE_EXTRACT.ctr = 9
             AND bkdosprt_#DATE_EXTRACT.eta = 'VA' THEN
            'SettledOnTime'
        ELSE
            'GrantedAndActivated'
    END                                                                               AS "ContractStatus",
    NULL                                                                              AS "TransfertStatus",
    decode(bkdosprt_#DATE_EXTRACT.natcdt, 'A', 'Installment', 'NonInstallment')             AS "TypeOfContract",
    CASE
        WHEN bkdosprt_#DATE_EXTRACT.typ IN ( '100', '101', '130', '131' ) THEN
            'ConsumerCredits'
        WHEN bkdosprt_#DATE_EXTRACT.typ IN ( '160', '162' ) THEN
            'CashCredit'
        WHEN bkdosprt_#DATE_EXTRACT.typ IN ( '200' ) THEN
            'EquipmentsCredit'
        WHEN bkdosprt_#DATE_EXTRACT.typ IN ( '167', '201', '202', '203', '264',
                                        '300', '330', '364' ) THEN
            'ResidentialRealEstateCredits'
        ELSE
            'Other'
    END                                                                               AS "PurposeOfFinancing",
    TO_CHAR(tau_int)                                                                  AS "InterestRate",
    decode(bkdosprt_#DATE_EXTRACT.dev, 952, 'XOF')                                         AS "CurrencyOfContract",
    decode(bkdosprt_#DATE_EXTRACT.mrbtech, 'R', 'CurrentAccount')                          AS "MethodOfPayment",
	CASE
		WHEN bkdosprt_#DATE_EXTRACT.mon < 1 THEN
			1
		ELSE
			bkdosprt_#DATE_EXTRACT.mon
	 END 																			  AS "TotalAmount",
    bkdosprt_#DATE_EXTRACT.map                                                             AS "InstallmentAmount",
    bkdosprt_#DATE_EXTRACT.nbe                                                             AS "NumberOfInstallments",
    NULL                                                                              AS "NumberOfOutstandingInstallment",
    CASE
        WHEN bkdosprt_#DATE_EXTRACT.ctr = 1
             AND bkdosprt_#DATE_EXTRACT.eta = 'VA' THEN
            bkdosprt_#DATE_EXTRACT.remb
        ELSE
            0
    END                                                                               AS "OutstandingAmount",
    CASE
        WHEN bkdosprt_#DATE_EXTRACT.ctr = 1
             AND bkdosprt_#DATE_EXTRACT.eta = 'VA'
             AND bkdosprt_#DATE_EXTRACT.dimp <= TO_DATE(:date_fin_periode,'DD/MM/YYYY')
             AND bkdosprt_#DATE_EXTRACT.mimp > 0 THEN
            round(bkdosprt_#DATE_EXTRACT.mimp)
        ELSE
            0
    END                                                                               AS "PastDueAmount",
    CASE
        WHEN bkdosprt_#DATE_EXTRACT.ctr = 1
             AND bkdosprt_#DATE_EXTRACT.eta = 'VA'
             AND bkdosprt_#DATE_EXTRACT.dimp <= TO_DATE(:date_fin_periode,'DD/MM/YYYY')
             AND bkdosprt_#DATE_EXTRACT.mimp > 0 THEN
            (
                SELECT
                    round(TO_DATE(:date_fin_periode,'DD/MM/YYYY') - MIN(bkechprt.dva))
                FROM
                    bkechprt
                WHERE
                        bkechprt.eve = bkdosprt_#DATE_EXTRACT.eve
                    AND bkechprt.ctr = '8'
            )
        ELSE
            0
    END                                                                               AS "PastDueDays",
    CASE
        WHEN bkdosprt_#DATE_EXTRACT.ctr = 1
             AND bkdosprt_#DATE_EXTRACT.eta = 'VA'
             AND bkdosprt_#DATE_EXTRACT.dimp <= TO_DATE(:date_fin_periode,'DD/MM/YYYY')
             AND bkdosprt_#DATE_EXTRACT.mimp > 0 THEN
            (
                SELECT
                    COUNT(*)
                FROM
                    bkechprt
                WHERE
                        bkechprt.eve = bkdosprt_#DATE_EXTRACT.eve
                    AND bkechprt.ctr = '8'
            )
        ELSE
            0
    END                                                                               AS "NumberOfDueInstallments",
    NULL                                                                              AS "AdditionalFeesPaid"
    ,
    (
        SELECT
            to_char(MAX(bkechprt.dva), 'YYYY-MM-DD')
        FROM
            bkechprt
        WHERE
                bkechprt.eve = bkdosprt_#DATE_EXTRACT.eve
            AND bkechprt.ave = bkdosprt_#DATE_EXTRACT.ave
            AND bkechprt.ctr = 9
            AND bkechprt.dva <= TO_DATE(:date_fin_periode,'DD/MM/YYYY')
    )                                                                                 AS "DateOfLastPayment",
    bkdosprt_#DATE_EXTRACT.map                                                             AS "TotalMonthlyPayment",
    decode(bkdosprt_#DATE_EXTRACT.unper, 'M', 'Days30', 'T', 'Days90',
           'FinalDay')                                                                AS "PaymentPeriodicity",
    to_char(bkdosprt_#DATE_EXTRACT.dmep, 'YYYY-MM-DD')                                     AS "StartDate",
    to_char(bkdosprt_#DATE_EXTRACT.ddec, 'YYYY-MM-DD')                                     AS "ExpectedEndDate",
    CASE
        WHEN bkdosprt_#DATE_EXTRACT.ctr = 9
             AND bkdosprt_#DATE_EXTRACT.eta = 'VA'
             AND bkdosprt_#DATE_EXTRACT.dtan IS NOT NULL THEN
            to_char(bkdosprt_#DATE_EXTRACT.dtan, 'YYYY-MM-DD')
        WHEN bkdosprt_#DATE_EXTRACT.ctr = 9
             AND bkdosprt_#DATE_EXTRACT.dtan IS NULL THEN
            (
                SELECT
                    to_char(MAX(bkechprt.dva), 'YYYY-MM-DD')
                FROM
                    bkechprt
                WHERE
                        bkechprt.eve = bkdosprt_#DATE_EXTRACT.eve
                    AND bkechprt.ave = bkdosprt_#DATE_EXTRACT.ave
                    AND res = 0
                    AND bkechprt.ctr = 9
            )
    END                                                                               AS "RealEndDate",
    decode(bkdosprt_#DATE_EXTRACT.ctr, '1', 'NotSpecified', 'NotSpecified')                 AS "NegativeStatusOfContract",
    CASE
        WHEN (
            SELECT
                vala
            FROM
                bkicli
            WHERE
                    iden = 'CONSENT'
                AND cli = bkdosprt_#DATE_EXTRACT.cli
        ) = 'O' THEN
            'Yes'
        ELSE
            'No'
    END                                                                               AS "Consented",
    CASE
        WHEN tcli IN ( '1' ) THEN
            'PhysicalPerson'
        WHEN ora_getcatn(bkdosprt_#DATE_EXTRACT.cli) = '23210'         THEN
            'LocalOrRegionalGovernment'
        WHEN ora_getcatn(bkdosprt_#DATE_EXTRACT.cli) = '23110'         THEN
            'StateOrCentralAdministration'
        WHEN ora_getseg(bkdosprt_#DATE_EXTRACT.cli) IN ( 'E31', 'E32', 'E33', 'I43', 'I45' ) THEN
            'LargeCompanies'
        WHEN ora_getseg(bkdosprt_#DATE_EXTRACT.cli) IN ( 'E34', 'E35', 'I41', 'I42' ) THEN
            'MediumCompanies'
        WHEN ora_getseg(bkdosprt_#DATE_EXTRACT.cli) IN ( 'E36', 'F21', 'F23', 'F24', 'F26',
                                                    'F25', 'I44', 'I46', 'I47', 'P12' ) THEN
            'SmallCompanies'
    END                                                                               AS "RecipientType",
    'Direct'                                                                          AS "CreditType",
    NULL                                                                              AS "IndirectCreditNature"
    ,
    CASE
        WHEN ( round((ddec - dmep) / 30) <= 3 ) THEN
            'Between0MonthAnd3Months'
        WHEN ( round((ddec - dmep) / 30) > 3
               AND ( round((ddec - dmep) / 30) <= 6 ) ) THEN
            'Between3MonthsAnd6Months'
        WHEN ( round((ddec - dmep) / 30) > 6
               AND ( round((ddec - dmep) / 30) <= 12 ) ) THEN
            'Between6MonthsAnd1Year'
        WHEN ( round((ddec - dmep) / 30) > 12
               AND ( round((ddec - dmep) / 30) <= 24 ) ) THEN
            'Between1YearAnd2Years'
        WHEN ( round((ddec - dmep) / 30) > 24
               AND ( round((ddec - dmep) / 30) <= 60 ) ) THEN
            'Between2YearsAnd5Years'
        WHEN ( round((ddec - dmep) / 30) > 60
               AND ( round((ddec - dmep) / 30) <= 120 ) ) THEN
            'Between5YearsAnd10Years'
        ELSE
            'Over10Years'
    END                                                                               AS "InitialCreditTerm",
    CASE
        WHEN ( round((ddec - dmep) / 30) <= 24 ) THEN
            'ShortTerm'
        WHEN ( round((ddec - dmep) / 30) >= 25
               AND round((ddec - dmep) / 30) <= 120 ) THEN
            'MiddleTerm'
        ELSE
            'LongTerm'
    END                                                                               AS "CreditTerm"
    ,
    CASE
        WHEN ( bkdosprt_#DATE_EXTRACT.typ IN ( '129', '199', '229', '299', '329',
                                          '399' ) ) THEN
            'SufferingDebts'
        ELSE
            'HealthyDebts'
    END                                                                               AS "NatureOfGrantedCredit",
    CASE
        WHEN ( bkdosprt_#DATE_EXTRACT.typ IN ( '129', '199', '229', '299', '329',
                                          '399' ) ) THEN
            'RestructuredDebts'
        ELSE
            NULL
    END                                                                               AS "OustandingCrediType",
    CASE
        WHEN ( trunc(to_date(sysdate, 'DD/MM/YYYY') - to_date(bkdosprt_#DATE_EXTRACT.dou, 'DD/MM/YYYY')) < 41 ) THEN
            'New'
        ELSE
            'Old'
    END                                                                               AS "StateOfContract",
    CASE
        WHEN bkdosprt_#DATE_EXTRACT.tau_int > bkdosprt_#DATE_EXTRACT.TEG
             THEN
            round(bkdosprt_#DATE_EXTRACT.tau_int)
        ELSE
            round(bkdosprt_#DATE_EXTRACT.teg)
    END                                                                              AS "EffectiveCreditRate",
    round(((to_date(:date_fin_periode)) - bkdosprt_#DATE_EXTRACT.dmep) / 30)                   AS "ContractLifetime",
    CASE
        WHEN (
            SELECT
                COUNT(*)
            FROM
                bkgrp,
                bkcli
            WHERE
                    bkcli.cli = bkdosprt_#DATE_EXTRACT.cli
                AND bkcli.grp = bkgrp.grp
        ) > 0 THEN
            'Yes'
        ELSE
            'No'
    END                                                                               AS "BelongsToGroup"
    ,
    (
        SELECT
            bkgrp.nom
        FROM
            bkgrp,
            bkcli
        WHERE
                bkcli.cli = bkdosprt_#DATE_EXTRACT.cli
            AND bkcli.grp = bkgrp.grp
    )                                                                                 AS "BelongsToGroupName",
    CASE
        WHEN ( (
            SELECT
                COUNT(*)
            FROM
                bkeng
            WHERE
                    TRIM(neng) = TRIM(bkdosprt_#DATE_EXTRACT.eve || bkdosprt_#DATE_EXTRACT.ave)
                AND eta = 'VA'
        ) > 0 ) THEN
            (
                SELECT
                    TRIM(ngar)
                FROM
                    bkeng
                WHERE
                        TRIM(neng) = TRIM(bkdosprt_#DATE_EXTRACT.eve || bkdosprt_#DATE_EXTRACT.ave)
                    AND eta = 'VA'
            )
        WHEN ( (
            SELECT
                COUNT(*)
            FROM
                bkeng
            WHERE
                    TRIM(neng) = TRIM(bkdosprt_#DATE_EXTRACT.eve || bkdosprt_#DATE_EXTRACT.ave)
                AND eta = 'VA'
        ) = 0 ) THEN
            bkcli.cli
    END                                                                               AS "CollateralCode"
    ,
    CASE
        WHEN ( (
            SELECT
                COUNT(*)
            FROM
                bkeng
            WHERE
                    TRIM(neng) = TRIM(bkdosprt_#DATE_EXTRACT.eve || bkdosprt_#DATE_EXTRACT.ave)
                AND eta = 'VA'
        ) > 0 ) THEN
            'Mortgages'
        WHEN ( (
                SELECT
                    COUNT(*)
                FROM
                    bkeng
                WHERE
                        TRIM(neng) = TRIM(bkdosprt_#DATE_EXTRACT.eve || bkdosprt_#DATE_EXTRACT.ave)
                    AND eta = 'VA'
            ) = 0
               AND bkcli.tcli = '1' ) THEN
            'SalaryDomiciliation'
        WHEN ( (
                SELECT
                    COUNT(*)
                FROM
                    bkeng
                WHERE
                        TRIM(neng) = TRIM(bkdosprt_#DATE_EXTRACT.eve || bkdosprt_#DATE_EXTRACT.ave)
                    AND eta = 'VA'
            ) = 0
               AND bkcli.tcli <> '1' ) THEN
            'Other'
    END                                                                               AS "CollateralType",
    NULL                                                                              AS "CollateralDescription",
    CASE
        WHEN ( (
            SELECT
                COUNT(*)
            FROM
                bkeng
            WHERE
                    TRIM(neng) = TRIM(bkdosprt_#DATE_EXTRACT.eve || bkdosprt_#DATE_EXTRACT.ave)
                AND eta = 'VA'
        ) > 0 ) THEN
            (
                SELECT
                    bkgar.mnta
                FROM
                    bkgar,
                    bkeng
                WHERE
                        bkgar.eve = bkeng.ngar
                    AND TRIM(neng) = TRIM(bkdosprt_#DATE_EXTRACT.eve || bkdosprt_#DATE_EXTRACT.ave)
            )
        WHEN ( (
                SELECT
                    COUNT(*)
                FROM
                    bkeng
                WHERE
                        TRIM(neng) = TRIM(bkdosprt_#DATE_EXTRACT.eve || bkdosprt_#DATE_EXTRACT.ave)
                    AND eta = 'VA'
            ) = 0
               AND bkcli.tcli = '1' ) THEN
            0
        WHEN ( (
                SELECT
                    COUNT(*)
                FROM
                    bkeng
                WHERE
                        TRIM(neng) = TRIM(bkdosprt_#DATE_EXTRACT.eve || bkdosprt_#DATE_EXTRACT.ave)
                    AND eta = 'VA'
            ) = 0
               AND bkcli.tcli <> '1' ) THEN
            0
    END                                                                               AS "CollateralValue",
    to_char(bkdosprt_#DATE_EXTRACT.dmep, 'YYYY-MM-DD')                                     AS "ValuationDate",
    CASE
        WHEN bkcli.tcli = '1' THEN
            TRIM(bkdosprt_#DATE_EXTRACT.cli)
    END                                                                               AS "CustomerCode",
    CASE
        WHEN bkcli.tcli = '1' THEN
            TRIM((bkcli.pre))
    END                                                                               AS "PresentSurname",
    CASE
        WHEN bkcli.tcli = '1' THEN
            TRIM((bkcli.nom))
    END                                                                               AS "FirstName",
    CASE
        WHEN bkcli.tcli = '1' THEN
            TRIM((bkcli.pre))
            || ' '
            || TRIM((nom))
    END                                                                               AS "FullName",
    CASE
        WHEN bkcli.tcli = '1' THEN
            TRIM((bkcli.nmer))
    END                                                                               AS "MothersjuindenName",
    CASE
        WHEN bkcli.tcli = '1' THEN
            bkcli.nbenf
    END                                                                               AS "NumberOfChildren",
    CASE
        WHEN bkcli.tcli = '1' THEN
            NULL
    END                                                                               AS "ClassificationOfIndividual",
    CASE
        WHEN bkcli.tcli = '1' THEN
            decode(bkcli.sext, 'M', 'Male', 'F', 'Female')
    END                                                                               AS "Gender",
    CASE
        WHEN bkcli.tcli = '1' THEN
            to_char(bkcli.dna, 'YYYY-MM-DD')
    END                                                                               AS "DateOfBirth",
    CASE
        WHEN bkcli.tcli = '1'
             AND TRIM(bkcli.payn) = '958' THEN
            'BJ'
        WHEN bkcli.tcli = '1'
             AND TRIM(bkcli.payn) != '958' THEN
            (
                SELECT
                    TRIM(bknom.lib2)
                FROM
                    bknom
                WHERE
                        TRIM(bknom.cacc) = TRIM(bkcli.payn)
                    AND TRIM(bknom.ctab) = '040'
            )
    END                                                                               AS "CountryOfBirth",
    CASE
        WHEN bkcli.tcli = '1' THEN
            viln
    END                                                                               AS "PlaceOfBirth",
    CASE
        WHEN bkcli.tcli = '1' THEN
            decode(bkcli.sit, 'M', 'Married', 'C', 'Single',
                   'D', 'Divorced', 'V', 'Widowed', 'Other')
    END                                                                               AS "MaritalStatus",
    CASE
        WHEN bkcli.tcli = '1' THEN
            NULL
    END                                                                               AS "SocialStatus",
    (
        SELECT
            TRIM(ora_getlib2nom('040', res))
        FROM
            bkcli
        WHERE
            cli = bkdosprt_#DATE_EXTRACT.cli
    )                                                                                 AS "Residency",
    (
        SELECT
            TRIM(ora_getlib5nom('033', nat))
        FROM
            bkcli
        WHERE
            cli = bkdosprt_#DATE_EXTRACT.cli
    )                                                                                 AS "Nationality",
    CASE
        WHEN bkcli.tcli = '1' THEN
            NULL
    END                                                                               AS "Employment",
    CASE
        WHEN bkcli.tcli = '1' THEN
            NULL
    END                                                                               AS "NegativeStatusOfIndividual",
    CASE
        WHEN ora_getseg(bkdosprt_#DATE_EXTRACT.cli) IN ( 'P11', 'P12' ) THEN
            'Employee'
        ELSE
            'UnclassifiableWorkers'
    END                                                                               AS "ProfessionalCategory",
    CASE
        WHEN bkcli.res = '284' THEN
            ( substr(nvl((
                SELECT
                    CASE
                        WHEN replace(TRIM(bk.num), ' ') = '22900000000' THEN
                            '+22997979797'
                        ELSE
                            (
                                CASE
                                    WHEN(substr(TRIM(bk.num), 1, 3)) != '229' THEN
                                        '+229'
                                        || replace(TRIM((regexp_replace(substr(TRIM(bk.num), 1, 24), '[-+/\:.,()]', ''))), ' ')
                                    ELSE
                                        '+'
                                        || replace(TRIM((regexp_replace(substr(TRIM(bk.num), 1, 24), '[-+/\:.,()]', ''))), ' ')
                                END
                            )
                    END
                FROM
                    DBEDI.BKTELCLI bk
                WHERE
                        bk.cli = bkcli.cli
                    AND substr(TRIM(bk.num), 4, 1) NOT IN('2', '3')
                    AND ROWNUM = 1
            ),
                         '+22997979797'),
                     0,
                     12) )
        ELSE
            (
                SELECT
                    '+'
                    || replace(TRIM((regexp_replace(substr(TRIM(bk.num), 1, 24), '[-+/\:.,()]', ''))), ' ')
                FROM
                    DBEDI.BKTELCLI bk
                WHERE
                        bk.cli = bkcli.cli
                    AND substr(TRIM(bk.num), 4, 1) NOT IN ( '2', '3' )
                    AND ROWNUM = 1
            )
    END                                                                               AS "PhoneNumber",
    '0'                                                                               AS "PaiementIncident"

,
    CASE
        WHEN bkcli.tcli = '2'
             OR bkcli.tcli = '3' THEN
            TRIM(bkcli.cli)
    END                                                                               AS "C_CustomerCode",
    CASE
        WHEN bkcli.tcli = '2'
             OR bkcli.tcli = '3' THEN
            rtrim(ltrim(regexp_replace(TRIM(bkcli.rso), '[-+/\:.,()&"]', '')))
    END                                                                               AS "CompanyName",
    CASE
        WHEN bkcli.tcli = '2'
             OR bkcli.tcli = '3' THEN
            rtrim(ltrim(bkcli.sig))
    END                                                                               AS "TradeName",
    CASE
        WHEN bkcli.tcli = '2'
             OR bkcli.tcli = '3' THEN
                CASE
                    WHEN TRIM(bkcli.fju) IN ( '02', '06' ) THEN
                        'LimitedLiabilityCompany'
                    WHEN TRIM(bkcli.fju) IN ( '03' ) THEN
                        'GeneralPartnership'
                    WHEN TRIM(bkcli.fju) IN ( '04' ) THEN
                        'LimitedPartnership'
                    WHEN TRIM(bkcli.fju) IN ( '09' ) THEN
                        'EconomicInterestGrouping'
                    WHEN TRIM(bkcli.fju) IN ( '11', '12' ) THEN
                        'Association'
                    ELSE
                        'Other'
                END
    END                                                                               AS "LegalForm",
    CASE
        WHEN bkcli.tcli = '2'
             OR bkcli.tcli = '3' THEN
                CASE
                    WHEN TRIM(bkcli.sitj) IN ( '002' ) THEN
                        'Active'
                    WHEN TRIM(bkcli.sitj) IN ( '004' ) THEN
                        'OtherCourtActionByBank'
                    WHEN TRIM(bkcli.sitj) IN ( '005' ) THEN
                        'Liquidation'
                    WHEN TRIM(bkcli.sitj) IN ( '006', '009' ) THEN
                        'Closed'
                    WHEN TRIM(bkcli.sitj) IN ( '007' ) THEN
                        'InBankrupcy'
                    WHEN TRIM(bkcli.sitj) IN ( '011' ) THEN
                        'AssetsFrozenOrSeized'
                    ELSE
                        'Active'
                END
    END                                                                               AS "BusinessStatus",
    CASE
        WHEN bkcli.tcli = '2'
             OR bkcli.tcli = '3' THEN
            to_char(bkcli.datc, 'YYYY-MM-DD')
    END                                                                               AS "EstablishmentDate",
    CASE
        WHEN bkcli.tcli = '2'
             OR bkcli.tcli = '3' THEN

                CASE
                    WHEN TRIM(bkcli.sec) IN ( 'C19', 'C20', 'H53' ) THEN
                        'PublicAdministrationActivities'
                    WHEN TRIM(bkcli.sec) IN ( 'C23', 'L68' ) THEN
                        'RealEstate'
                    WHEN TRIM(bkcli.sec) IN ( 'A01', 'N82' ) THEN
                        'AgricultureForestryFishing'
                    WHEN TRIM(bkcli.sec) IN ( 'K65', 'S96' ) THEN
                        'FinancialAndInsuranceActivities'
                    WHEN TRIM(bkcli.sec) IN ( 'F41' ) THEN
                        'Construction'
                    WHEN TRIM(bkcli.sec) IN ( 'G47' ) THEN
                        'Trade'
                    WHEN TRIM(bkcli.sec) IN ( 'G46' ) THEN
                        'Trade'
                    WHEN TRIM(bkcli.sec) IN ( 'J61' ) THEN
                        'InformationAndCommunication'
                    WHEN TRIM(bkcli.sec) IN ( 'D35', 'H52' ) THEN
                        'ProductionAndDistributionOfElectricityAndGas'
                    WHEN TRIM(bkcli.sec) IN ( 'K64' ) THEN
                        'FinancialAndInsuranceActivities'
                    WHEN TRIM(bkcli.sec) IN ( 'B07', 'B08', 'C20', 'C32', 'F42' ) THEN
                        'Mining'
                    WHEN TRIM(bkcli.sec) IN ( 'B07', 'D35' ) THEN
                        'Mining'
                    WHEN TRIM(bkcli.sec) IN ( 'B05' ) THEN
                        'Coal Mining'
                    WHEN TRIM(bkcli.sec) IN ( 'C10', 'C12', 'C31', 'H50', 'H52',
                                              'L68' ) THEN
                        'AccommodationAndCatering'
                    WHEN TRIM(bkcli.sec) IN ( 'C15', 'C28' ) THEN
                        'Manufacturing'
                    WHEN TRIM(bkcli.sec) IN ( 'C16', 'C20', 'C24' ) THEN
                        'Manufacturing'
                    WHEN TRIM(bkcli.sec) IN ( 'D35' ) THEN
                        'Manufacturing'
                    WHEN TRIM(bkcli.sec) IN ( 'C14', 'G46' ) THEN
                        'Manufacturing'
                    WHEN TRIM(bkcli.sec) IN ( 'A03' ) THEN
                        'AgricultureForestryFishing'
                    WHEN TRIM(bkcli.sec) IN ( 'C23' ) THEN
                        'Manufacturing'
                    WHEN TRIM(bkcli.sec) IN ( 'C10' ) THEN
                        'AccommodationAndCatering'
                    WHEN TRIM(bkcli.sec) IN ( 'D35', 'K64' ) THEN
                        'SpecialActivitiesOfHouseholds'
                    WHEN TRIM(bkcli.sec) IN ( 'C10', 'R93' ) THEN
                        'ArtisticSsportsAndRecreational'
                    WHEN TRIM(bkcli.sec) IN ( 'S95' ) THEN
                        'HumanHealthAndSocialAction'
                    WHEN TRIM(bkcli.sec) IN ( 'Q87', 'S94' ) THEN
                        'SupportAndOfficeServicesActivities'
                    WHEN TRIM(bkcli.sec) IN ( 'A02' ) THEN
                        'AgricultureForestryFishing'
                    WHEN TRIM(bkcli.sec) IN ( 'C16', 'D35', 'H49', 'H50', 'H51',
                                              'H52' ) THEN
                        'TransportAndWarehousing'
                    ELSE
                        'OtherNCAServicesActivities'
                END
    END                                                                               AS "IndustrySector",
    (
        SELECT
            TRIM(ora_getlib2nom('040', res))
        FROM
            bkcli
        WHERE
            cli = bkdosprt_#DATE_EXTRACT.cli
    )                                                                                 AS "Residency",
    (
        SELECT
            TRIM(ora_getlib5nom('033', nat))
        FROM
            bkcli
        WHERE
            cli = bkdosprt_#DATE_EXTRACT.cli
    )                                                                                 AS "Nationality",
    CASE
        WHEN (
            SELECT
                sig
            FROM
                bkcli
            WHERE
                cli = bkdosprt_#DATE_EXTRACT.cli
        ) = ' ' THEN
            substr((
                SELECT
                    rso
                FROM
                    bkcli
                WHERE
                    cli = bkdosprt_#DATE_EXTRACT.cli
            ), 0, 60)
        ELSE
            substr((
                SELECT
                    sig
                FROM
                    bkcli
                WHERE
                    cli = bkdosprt_#DATE_EXTRACT.cli
            ), 0, 60)
    END                                                                               AS "Sigle",
    decode(TRIM(ora_getcatn(bkdosprt_#DATE_EXTRACT.cli)), '21100', 'CentralBanks', '21101', 'CentralBanks',
           '21210', '2', '21220', 'Banks',
           '21221',
           'Banks',
           '21230',
           'Banks',
           '21240',
           'BankingFinancialInstitutionsAuthorizedToReceiveDeposits',
           '21250',
           'SFDAuthorizedToCollectDeposits',
           '21311',
           'InsuranceCompanies',
           '21312',
           'PensionFunds',
           '21321',
           'BankingFinancialInstitutionsNotAuthorizedToReceiveDeposits',
           '21322',
           'SFDNotAllowedToCollectSavings',
           '21323',
           'VariousOtherFinancialIntermediaries',
           '21330',
           'FinancialAuxiliaries',
           '22110',
           'NonFinancialCorporationsPrimarilyEngagedInProducingGoodsOrProvidingMarketServices',
           '22120',
           'PublicEstablishmentsOfAnIndustrialOrCommercialNatureWhichAreStateOrPublicOrganizations',
           '22210',
           'ForeignControlledNonFinancialCorporations',
           '22220',
           'NationalPrivateNonFinancialCorporations',
           '23110',
           'CentralPublicAdministration',
           '23210',
           'LocalAndRegionalGovernment',
           '23310',
           'SocialSecurityDirections',
           '24100',
           'IndividualCompanies',
           '24110',
           'Banks',
           '25100',
           'NonProfitInstitutionsServingHouseholds',
           '26100',
           'MultilateralDevelopmentBanks',
           '26200',
           'OtherInternationalFinancialInstitutions',
           '27100',
           ' OtherOrganizations',
           ' OtherOrganizations')                                                     AS "EconomicStatus",
    '0'                                                                               AS "PaiementIncident",
    '0'                                                                               AS "AnnualSales",
    CASE
        WHEN bkcli.tcli = '2'
             OR bkcli.tcli = '3' THEN
            replace(replace(replace(replace(TRIM(nrc), ' '), '-'), '.'), '/')
    END                                                                               AS "RegistrationNumber",
    CASE
        WHEN TRIM(lrc) = 'CI'     THEN
                CASE
                    WHEN ( bkcli.tcli = '2'
                           OR bkcli.tcli = '3' )
                         AND replace(TRIM(nrc), ' ') IS NOT NULL THEN
                        'CI'
                END
        WHEN TRIM(lrc) = 'ML'     THEN
                CASE
                    WHEN ( bkcli.tcli = '2'
                           OR bkcli.tcli = '3' )
                         AND replace(TRIM(nrc), ' ') IS NOT NULL THEN
                        'ML'
                END
        WHEN TRIM(lrc) = 'GW'     THEN
                CASE
                    WHEN ( bkcli.tcli = '2'
                           OR bkcli.tcli = '3' )
                         AND replace(TRIM(nrc), ' ') IS NOT NULL THEN
                        'GW'
                END
        WHEN TRIM(lrc) = 'BF'     THEN
                CASE
                    WHEN ( bkcli.tcli = '2'
                           OR bkcli.tcli = '3' )
                         AND replace(TRIM(nrc), ' ') IS NOT NULL THEN
                        'BF'
                END
        WHEN TRIM(lrc) = 'BJ'     THEN
                CASE
                    WHEN ( bkcli.tcli = '2'
                           OR bkcli.tcli = '3' )
                         AND replace(TRIM(nrc), ' ') IS NOT NULL THEN
                        'BJ'
                END
        WHEN TRIM(lrc) = 'NI'     THEN
                CASE
                    WHEN ( bkcli.tcli = '2'
                           OR bkcli.tcli = '3' )
                         AND replace(TRIM(nrc), ' ') IS NOT NULL THEN
                        'NI'
                END
        WHEN TRIM(lrc) = 'SN'     THEN
                CASE
                    WHEN ( bkcli.tcli = '2'
                           OR bkcli.tcli = '3' )
                         AND replace(TRIM(nrc), ' ') IS NOT NULL THEN
                        'SN'
                END
        ELSE
            'BJ'
    END                                                                               "RegistrationNumberIssuerCountr"
    ,
    CASE
        WHEN bkcli.tcli = '2'
             OR bkcli.tcli = '3' THEN
            replace(replace(TRIM(nidf), ' '), '/')
    END                                                                               AS "TaxNumber",
    CASE
        WHEN TRIM(lrc) = 'CI'     THEN
                CASE
                    WHEN ( bkcli.tcli = '2'
                           OR bkcli.tcli = '3' )
                         AND replace(TRIM(nrc), ' ') IS NOT NULL THEN
                        'CI'
                END
        WHEN TRIM(lrc) = 'ML'     THEN
                CASE
                    WHEN ( bkcli.tcli = '2'
                           OR bkcli.tcli = '3' )
                         AND replace(TRIM(nrc), ' ') IS NOT NULL THEN
                        'ML'
                END
        WHEN TRIM(lrc) = 'GW'     THEN
                CASE
                    WHEN ( bkcli.tcli = '2'
                           OR bkcli.tcli = '3' )
                         AND replace(TRIM(nrc), ' ') IS NOT NULL THEN
                        'GW'
                END
        WHEN TRIM(lrc) = 'BF'     THEN
                CASE
                    WHEN ( bkcli.tcli = '2'
                           OR bkcli.tcli = '3' )
                         AND replace(TRIM(nrc), ' ') IS NOT NULL THEN
                        'BF'
                END
        WHEN TRIM(lrc) = 'BJ'     THEN
                CASE
                    WHEN ( bkcli.tcli = '2'
                           OR bkcli.tcli = '3' )
                         AND replace(TRIM(nrc), ' ') IS NOT NULL THEN
                        'BJ'
                END
        WHEN TRIM(lrc) = 'NI'     THEN
                CASE
                    WHEN ( bkcli.tcli = '2'
                           OR bkcli.tcli = '3' )
                         AND replace(TRIM(nrc), ' ') IS NOT NULL THEN
                        'NI'
                END
        WHEN TRIM(lrc) = 'SN'     THEN
                CASE
                    WHEN ( bkcli.tcli = '2'
                           OR bkcli.tcli = '3' )
                         AND replace(TRIM(nrc), ' ') IS NOT NULL THEN
                        'SN'
                END
        ELSE
            'BJ'
    END                                                                               AS "TaxNumberIssuerCountry"
    ,
    CASE
        WHEN bkcli.tcli = '2'
             OR bkcli.tcli = '3' THEN
            NULL
    END                                                                               AS "BCEAONumber",
    CASE
        WHEN bkcli.tcli = '2'
             OR bkcli.tcli = '3' THEN
            NULL
    END                                                                               AS "BCEAONumberIssuerCountry",

    CASE
        WHEN bkcli.tid IN ( '00001', '50000' )
             AND bkcli.tcli = '1' THEN
            replace(TRIM(bkcli.nid), ' ')
    END                                                                               AS "NationalID",
    CASE
        WHEN bkcli.tid IN ( '00001', '50000' )
             AND bkcli.tcli = '1' THEN
            to_char(bkcli.did, 'YYYY-MM-DD')
    END                                                                               AS "NationalIDIssueDate",
    CASE
        WHEN bkcli.tid IN ( '00001', '50000' )
             AND bkcli.tcli = '1' THEN
            to_char(bkcli.vid, 'YYYY-MM-DD')
    END                                                                               AS "NationalIDExpirationDate",
    CASE
        WHEN bkcli.tid IN ( '00001', '50000' )
             AND bkcli.tcli = '1'
             AND TRIM(bkcli.payn) = '958' THEN
            'BJ'
        WHEN bkcli.tid IN ( '00001', '50000' )
             AND bkcli.tcli = '1'
             AND (
            SELECT
                TRIM(ora_getlib5nom('033', nat))
            FROM
                bkcli
            WHERE
                cli = bkdosprt_#DATE_EXTRACT.cli
        ) = 'BJ' THEN
            'BJ'
        WHEN bkcli.tid IN ( '00001', '50000' )
             AND bkcli.tcli = '1'
             AND TRIM(bkcli.payn) != '958' THEN
            (
                SELECT
                    TRIM(bknom.lib2)
                FROM
                    bknom
                WHERE
                        TRIM(bknom.cacc) = TRIM(bkcli.payn)
                    AND TRIM(bknom.ctab) = '040'
            )
    END                                                                               AS "NationalIDIssuerCountry",
    CASE
        WHEN bkcli.tid = '00002'
             AND bkcli.tcli = '1' THEN
            replace(TRIM(bkcli.nid), ' ')
    END                                                                               AS "PassportNumber",
    CASE
        WHEN bkcli.tid = '00002'
             AND bkcli.tcli = '1' THEN
            to_char(bkcli.did, 'YYYY-MM-DD')
    END                                                                               AS "PassportIssueDate",
    CASE
        WHEN bkcli.tid = '00002'
             AND bkcli.tcli = '1' THEN
            to_char(bkcli.vid, 'YYYY-MM-DD')
    END                                                                               AS "PassportExpirationDate",
    CASE
        WHEN bkcli.tid = '00002'
             AND bkcli.tcli = '1'
             AND TRIM(bkcli.payn) = '958' THEN
            'BJ'
        WHEN bkcli.tid IN ( '00002' )
             AND bkcli.tcli = '1'
             AND (
            SELECT
                TRIM(ora_getlib5nom('033', nat))
            FROM
                bkcli
            WHERE
                cli = bkdosprt_#DATE_EXTRACT.cli
        ) = 'BJ' THEN
            'BJ'
        WHEN bkcli.tid = '00002'
             AND bkcli.tcli = '1' THEN
            (
                SELECT
                    TRIM(bknom.lib2)
                FROM
                    bknom
                WHERE
                        TRIM(bknom.cacc) = TRIM(bkcli.payn)
                    AND TRIM(bknom.ctab) = '040'
            )
    END                                                                               AS "PassportIssuerCountry",
    CASE
        WHEN bkcli.tid = '00005'
             AND bkcli.tcli = '1' THEN
            replace(TRIM(bkcli.nid), ' ')
    END                                                                               AS "ResidencePermitNumber",
    CASE
        WHEN bkcli.tid = '00005'
             AND bkcli.tcli = '1' THEN
            to_char(bkcli.did, 'YYYY-MM-DD')
    END                                                                               AS "ResidencePermitIssueDate",
    CASE
        WHEN bkcli.tid = '00005'
             AND bkcli.tcli = '1' THEN
            to_char(bkcli.vid, 'YYYY-MM-DD')
    END                                                                               AS "ResidencePermitExpirationDate",
    CASE
        WHEN bkcli.tid = '00005'
             AND bkcli.tcli = '1'
             AND TRIM(bkcli.payn) = '958' THEN
            'BJ'
        WHEN bkcli.tid IN ( '00005' )
             AND bkcli.tcli = '1'
             AND (
            SELECT
                TRIM(ora_getlib5nom('033', nat))
            FROM
                bkcli
            WHERE
                cli = bkdosprt_#DATE_EXTRACT.cli
        ) = 'BJ' THEN
            'BJ'
        WHEN bkcli.tid = '00005'
             AND bkcli.tcli = '1' THEN
            (
                SELECT
                    TRIM(bknom.lib2)
                FROM
                    bknom
                WHERE
                        TRIM(bknom.cacc) = TRIM(bkcli.payn)
                    AND TRIM(bknom.ctab) = '040'
            )
    END                                                                               AS "ResidencePermitIssuerCountry",
    CASE
        WHEN bkcli.tid = '00009'
             AND bkcli.tcli = '1' THEN
            NULL
    END                                                                               AS "DrivingLicenseNumber",
    CASE
        WHEN bkcli.tid = '00009'
             AND bkcli.tcli = '1' THEN
            NULL
    END                                                                               AS "DrivingLicenseIssueDate",
    CASE
        WHEN bkcli.tid = '00009'
             AND bkcli.tcli = '1' THEN
            NULL
    END                                                                               AS "DrivingLicenseExpirationDate",
    CASE
        WHEN bkcli.tid = '00009'
             AND bkcli.tid = '1'
             AND bkcli.tcli = '1'
             AND TRIM(bkcli.payn) = '958' THEN
            'BJ'
        WHEN bkcli.tid = '00009'
             AND bkcli.tcli = '1' THEN
            NULL
    END                                                                               AS "DrivingLicenseIssuerCountry",
    CASE
        WHEN bkcli.tid = '00007'
             AND bkcli.tcli = '1' THEN
            replace(TRIM(bkcli.nid), ' ')
    END                                                                               AS "ConsularCard",
    CASE
        WHEN bkcli.tid = '00007'
             AND bkcli.tcli = '1' THEN
            to_char(bkcli.did, 'YYYY-MM-DD')
    END                                                                               AS "ConsularCardIssueDate",
    CASE
        WHEN bkcli.tid = '00007'
             AND bkcli.tcli = '1' THEN
            to_char(bkcli.vid, 'YYYY-MM-DD')
    END                                                                               AS "ConsularCardExpirationDate",
    CASE
        WHEN bkcli.tid = '00007'
             AND bkcli.tcli = '1'
             AND TRIM(bkcli.payn) = '958' THEN
            'BJ'
        WHEN bkcli.tid IN ( '00007' )
             AND bkcli.tcli = '1'
             AND (
            SELECT
                TRIM(ora_getlib5nom('033', nat))
            FROM
                bkcli
            WHERE
                cli = bkdosprt_#DATE_EXTRACT.cli
        ) = 'BJ' THEN
            'BJ'
        WHEN bkcli.tid = '00007'
             AND bkcli.tcli = '1' THEN
            (
                SELECT
                    TRIM(bknom.lib2)
                FROM
                    bknom
                WHERE
                        TRIM(bknom.cacc) = TRIM(bkcli.payn)
                    AND TRIM(bknom.ctab) = '040'
            )
    END                                                                               AS "ConsularCardIssuerCountry",
    CASE
        WHEN ( bkcli.tid IN ( '00008', '00010', '00097', '00098', '00012',
                              '00013', '00014', '00003', '00004', '00006',
                              '00011' )
               AND bkcli.tcli = '1' ) THEN
            replace(TRIM(bkcli.nid), ' ')
    END                                                                               AS "IDDocumentNumber",
    CASE
        WHEN ( bkcli.tid IN ( '00008', '00010', '00097', '00098', '00012',
                              '00013', '00014', '00003', '00004', '00006',
                              '00011' )
               AND bkcli.tcli = '1' ) THEN
            to_char(bkcli.did, 'YYYY-MM-DD')
    END                                                                               AS "IDDocumentIssueDate",
    CASE
        WHEN ( bkcli.tid IN ( '00008', '00010', '00097', '00098', '00012',
                              '00013', '00014', '00003', '00004', '00006',
                              '00011' )
               AND bkcli.tcli = '1' ) THEN
            to_char(bkcli.vid, 'YYYY-MM-DD')
    END                                                                               AS "IDDocumentExpirationDate",
    CASE
        WHEN ( bkcli.tid IN ( '00008', '00010', '00097', '00098', '00012',
                              '00013', '00014', '00003', '00004', '00006',
                              '00011' )
               AND bkcli.tcli = '1' )
             AND TRIM(bkcli.payn) = '958' THEN
            'BJ'
        WHEN bkcli.tid IN ( '00008', '00010', '00097', '00098', '00012',
                            '00013', '00014', '00003', '00004', '00006',
                            '00011' )
             AND bkcli.tcli = '1'
             AND (
            SELECT
                TRIM(ora_getlib5nom('033', nat))
            FROM
                bkcli
            WHERE
                cli = bkdosprt_#DATE_EXTRACT.cli
        ) = 'BJ' THEN
            'BJ'
        WHEN ( bkcli.tid IN ( '00008', '00010', '00097', '00098', '00012',
                              '00013', '00014', '00003', '00004', '00006',
                              '00011' )
               AND bkcli.tcli = '1' ) THEN
            (
                SELECT
                    TRIM(bknom.lib2)
                FROM
                    bknom
                WHERE
                        TRIM(bknom.cacc) = TRIM(bkcli.payn)
                    AND TRIM(bknom.ctab) = '040'
            )
    END                                                                               AS "IDDocumentIssuerCountry",
    CASE
        WHEN ( bkcli.tid IN ( '00008', '00010', '00097', '00098', '00012',
                              '00013', '00014', '00003', '00004', '00006',
                              '00011' )
               AND bkcli.tcli = '1' ) THEN
            'ONI'
        WHEN bkcli.tid IN ( '00008' )
             AND bkcli.tcli = '1' THEN
            'MINISTERE DEFENSE'
        ELSE
            oid
    END                                                                               AS "IDDocumentIssueAuthority",
    CASE
        WHEN ( rtrim(ltrim((SELECT bkadcli.bpos FROM bkadcli WHERE cli = bkcli.cli  and rownum =1)))
               || ' '
               || rtrim(ltrim((SELECT bkadcli.ville FROM bkadcli WHERE cli = bkcli.cli  and rownum =1))) ) IS NOT NULL THEN
            rtrim(ltrim((SELECT bkadcli.bpos FROM bkadcli WHERE cli = bkcli.cli  and rownum =1)))
    END                                                                               AS "POBox",
    CASE
        WHEN rtrim(ltrim((SELECT distinct  bkadcli.adr2 FROM bkadcli WHERE cli = bkcli.cli and rownum =1  ))) IS NOT NULL THEN
            rtrim(ltrim((SELECT distinct  bkadcli.adr2 FROM bkadcli WHERE cli = bkcli.cli and rownum =1  )))
    END                                                                               AS "Street",
    CASE
        WHEN rtrim(ltrim((SELECT bkadcli.ville FROM bkadcli WHERE cli = bkcli.cli  and rownum =1))) IS NOT NULL THEN
            rtrim(ltrim((SELECT bkadcli.ville FROM bkadcli WHERE cli = bkcli.cli  and rownum =1)))
    END                                                                               AS "City",
    NULL                                                                              AS "State",
    (
        SELECT
            TRIM(bknom.lib2)
        FROM
            bknom
        WHERE
                TRIM(bknom.cacc) = TRIM((SELECT bkadcli.cpay FROM bkadcli WHERE cli = bkcli.cli  and rownum =1 ))
            AND TRIM(bknom.ctab) = '040'
    )                                                                                 AS "Country",
    CASE
        WHEN rtrim(ltrim((SELECT distinct  bkadcli.adr1 FROM bkadcli WHERE cli = bkcli.cli and rownum =1  ))) IS NOT NULL THEN
            rtrim(ltrim((SELECT distinct  bkadcli.adr1 FROM bkadcli WHERE cli = bkcli.cli and rownum =1  )))
    END                                                                               AS "AddressLine",
    NULL                                                                              AS "SA_POBox",
    NULL                                                                              AS "SA_Street",
    NULL                                                                              AS "SA_City",
    NULL                                                                              AS "SA_State",
    NULL                                                                              AS "SA_Country",
    NULL                                                                              AS "SA_AddressLine"
    ,
    CASE
        WHEN bkcli.res = '284' THEN
            ( substr(nvl((
                SELECT
                    CASE
                        WHEN replace(TRIM(bk.num), ' ') = '22900000000' THEN
                            '+22997979797'
                        ELSE
                            (
                                CASE
                                    WHEN(substr(TRIM(bk.num), 1, 3)) != '229' THEN
                                        '+229'
                                        || replace(TRIM((regexp_replace(substr(TRIM(bk.num), 1, 24), '[-+/\:.,()]', ''))), ' ')
                                    ELSE
                                        '+'
                                        || replace(TRIM((regexp_replace(substr(TRIM(bk.num), 1, 24), '[-+/\:.,()]', ''))), ' ')
                                END
                            )
                    END
                FROM
                    DBEDI.BKTELCLI bk
                WHERE
                        bk.cli = bkcli.cli
                    AND substr(TRIM(bk.num), 4, 1) NOT IN('2', '3')
                    AND ROWNUM = 1
            ),
                         '+22997979797'),
                     0,
                     12) )
        ELSE
            (
                SELECT
                    '+'
                    || replace(TRIM((regexp_replace(substr(TRIM(bk.num), 1, 24), '[-+/\:.,()]', ''))), ' ')
                FROM
                    DBEDI.BKTELCLI bk
                WHERE
                        bk.cli = bkcli.cli
                    AND substr(TRIM(bk.num), 4, 1) NOT IN ( '2', '3' )
                    AND ROWNUM = 1
            )
    END                                                                               AS "MobilePhone",
    CASE
        WHEN bkcli.res = '284' THEN
            (
                SELECT
                    CASE
                        WHEN replace(TRIM(bk.num), ' ') = '22900000000' THEN
                            '+22921313100'
                        ELSE
                            (
                                CASE
                                    WHEN substr(TRIM(bk.num), 1, 3) != '229' THEN
                                        '+22921313100'
                                    ELSE
                                        '+'
                                        || replace(TRIM((regexp_replace(substr(TRIM(bk.num), 1, 24), '[-+/\:.,()]', ''))), ' ')
                                END
                            )
                    END
                FROM
                    DBEDI.BKTELCLI bk
                WHERE
                        bk.cli = bkcli.cli
                    AND substr(TRIM(bk.num), 4, 1) IN ( '2', '3' )
                    AND ROWNUM = 1
            )
        ELSE
            (
                SELECT
                    '+'
                    || replace(TRIM((regexp_replace(substr(TRIM(bk.num), 1, 24), '[-+/\:.,()]', ''))), ' ')
                FROM
                    DBEDI.BKTELCLI bk
                WHERE
                        bk.cli = bkcli.cli
                    AND ROWNUM = 1
            )
    END                                                                               AS "FixedLine",
    rtrim(ltrim((SELECT bkadcli.email FROM bkadcli WHERE cli = bkcli.cli  and rownum =1  )))                                                       AS "Email",
    NULL                                                                              AS "WebPage",
    NULL                                                                              AS "Fax",
    TRIM(bkdosprt_#DATE_EXTRACT.cli)                                                       AS "CustomerCodeRole",
    decode((SELECT bkcliprt.num_ord FROM bkcliprt where cli = bkcli.cli AND rownum =1), 1, 'MainDebtor', 'CoDebtor')                    AS "RoleOfCustomer"
FROM
 bkdosprt_#DATE_EXTRACT,
 bkcli,
 bkcliprt_#DATE_EXTRACT

WHERE  bkdosprt_#DATE_EXTRACT.cli = bkcli.cli
AND bkdosprt_#DATE_EXTRACT.eve || bkdosprt_#DATE_EXTRACT.ave IN (SELECT  reference FROM BIC_DECLARATIONS )
