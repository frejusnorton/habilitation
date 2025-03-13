SELECT DISTINCT
    'E' || BKEFR_#DATE_EXTRACT.neff                                                       AS "ContractCode",
    CASE
        WHEN (
            SELECT
                vala
            FROM
                bkicli
            WHERE
                    bkicli.cli = BKEFR_#DATE_EXTRACT.cli
                AND iden = 'CONSENT'
        ) = 'O' THEN
            TRIM(BKEFR_#DATE_EXTRACT.cli)
        ELSE
            concat('BJLOI2020-08', TRIM(BKEFR_#DATE_EXTRACT.cli))
    END                                                                     AS "ConsentCode",
    (
        SELECT
            rtrim(ltrim(lib))
        FROM
            bkage
        WHERE
            TRIM(bkage.age) = TRIM(BKEFR_#DATE_EXTRACT.age)
    )                                                                       AS "Branch",
    decode(BKEFR_#DATE_EXTRACT.vie, '0', 'Open', '1', 'Open',
           '2', 'Closed', '9', 'Closed')                                    AS "PhaseOfContract",
    decode(BKEFR_#DATE_EXTRACT.vie, '0', 'GrantedAndActivated', 'SettledOnTime')          AS "ContractStatus",
    decode(BKEFR_#DATE_EXTRACT.vie, '2', 'SettledOnTime', 'GrantedAndActivated')          AS "TransfertStatus",
    decode(BKEFR_#DATE_EXTRACT.teff, '1', 'Installment', 'NonInstallment')                AS "TypeOfContract",
    'Other'                                                                 AS "PurposeOfFinancing",
    COALESCE((BKEFR_#DATE_EXTRACT.teg), 0)                                                AS "InterestRate",
    decode(BKEFR_#DATE_EXTRACT.dev, 952, 'XOF', 840, 'USD',
           978, 'EURO')                                                     AS "CurrencyOfContract",
    'CurrentAccount'                                                        AS "MethodOfPayment",
    CAST(BKEFR_#DATE_EXTRACT.mdev AS DECIMAL(18, 0))                                      AS "TotalAmount",
    'NULL'                                                                    AS "InstallmentAmount",
    'NULL'                                                                    AS "NumberOfInstallments",
    'NULL'                                                                    AS "NumberOfOutstandingInstallment",
    0.00                                                                    AS "OutstandingAmount",
    0.00                                                                    AS "PastDueAmount",
    0                                                                       AS "PastDueDays",
    0                                                                       "NumberOfDueInstallments",
    'NULL'                                                                    AS "AdditionalFeesPaid",
    'NULL'                                                                    AS "DateOfLastPayment",
    CAST(BKEFR_#DATE_EXTRACT.mdev AS DECIMAL(18, 0))                                      AS "TotalMonthlyPayment",
    'FinalDay'                                                              AS "PaymentPeriodicity",
    to_char(BKEFR_#DATE_EXTRACT.dou, 'YYYY-MM-DD')                                        AS "StartDate",
    to_char(BKEFR_#DATE_EXTRACT.dech, 'YYYY-MM-DD')                                       AS "ExpectedEndDate",
    CASE
        WHEN ((BKEFR_#DATE_EXTRACT.vie = '2' or BKEFR_#DATE_EXTRACT.vie = '9') and (BKEFR_#DATE_EXTRACT.dou >= BKEFR_#DATE_EXTRACT.dech)) THEN
         to_char(BKEFR_#DATE_EXTRACT.dsor, 'YYYY-MM-DD')
        WHEN ((BKEFR_#DATE_EXTRACT.vie = '2' or BKEFR_#DATE_EXTRACT.vie = '9') and (BKEFR_#DATE_EXTRACT.dou < BKEFR_#DATE_EXTRACT.dech)) THEN
            to_char(BKEFR_#DATE_EXTRACT.dech, 'YYYY-MM-DD')
        ELSE
            'NULL'
    END                                                                     AS "RealEndDate",
    'NULL'                                                                    AS "NegativeStatusOfContract",
    CASE
        WHEN (
            SELECT
                vala
            FROM
                bkicli
            WHERE
                    iden = 'CONSENT'
                AND cli = BKEFR_#DATE_EXTRACT.cli
        ) = 'O' THEN
            'Yes'
        ELSE
            'No'
    END                                                                     AS "Consented",
    CASE
        WHEN tcli IN ( '1' ) THEN
            'PhysicalPerson'
        WHEN ora_getcatn(BKEFR_#DATE_EXTRACT.cli) = '23210'       THEN
            'LocalOrRegionalGovernment'
        WHEN ora_getcatn(BKEFR_#DATE_EXTRACT.cli) = '23110'       THEN
            'StateOrCentralAdministration'
        WHEN ora_getseg(BKEFR_#DATE_EXTRACT.cli) IN ( 'E31', 'E32', 'E33', 'I43', 'I45' ) THEN
            'LargeCompanies'
        WHEN ora_getseg(BKEFR_#DATE_EXTRACT.cli) IN ( 'E34', 'E35', 'I41', 'I42' ) THEN
            'MediumCompanies'
        WHEN ora_getseg(BKEFR_#DATE_EXTRACT.cli) IN ( 'E36', 'F21', 'F23', 'F24', 'F25',
                                        'F26', 'I44', 'I46',
                                        'I47',
                                        'P12' ) THEN
            'SmallCompanies'
    END                                                                     AS "RecipientType",
    'Indirect'                                                              AS "CreditType",
    'Bail'                                                                  AS "IndirectCreditNature" ,
    CASE
        WHEN ( round((BKEFR_#DATE_EXTRACT.dech - BKEFR_#DATE_EXTRACT.dou) / 30) <= 3 ) THEN
            'Between0MonthAnd3Months'
        WHEN ( round((BKEFR_#DATE_EXTRACT.dech - BKEFR_#DATE_EXTRACT.dou) / 30) > 3
               AND ( round((BKEFR_#DATE_EXTRACT.dech - BKEFR_#DATE_EXTRACT.dou) / 30) <= 6 ) ) THEN
            'Between3MonthsAnd6Months'
        WHEN ( round((BKEFR_#DATE_EXTRACT.dech - BKEFR_#DATE_EXTRACT.dou) / 30) > 6
               AND ( round((BKEFR_#DATE_EXTRACT.dech - BKEFR_#DATE_EXTRACT.dou) / 30) <= 12 ) ) THEN
            'Between6MonthsAnd1Year'
        WHEN ( round((BKEFR_#DATE_EXTRACT.dech - BKEFR_#DATE_EXTRACT.dou) / 30) > 12
               AND ( round((BKEFR_#DATE_EXTRACT.dech - BKEFR_#DATE_EXTRACT.dou) / 30) <= 24 ) ) THEN
            'Between1YearAnd2Years'
        WHEN ( round((BKEFR_#DATE_EXTRACT.dech - BKEFR_#DATE_EXTRACT.dou) / 30) > 24
               AND ( round((BKEFR_#DATE_EXTRACT.dech - BKEFR_#DATE_EXTRACT.dou) / 30) <= 60 ) ) THEN
            'Between2YearsAnd5Years'
        WHEN ( round((BKEFR_#DATE_EXTRACT.dech - BKEFR_#DATE_EXTRACT.dou) / 30) > 60
               AND ( round((BKEFR_#DATE_EXTRACT.dech - BKEFR_#DATE_EXTRACT.dou) / 30) <= 120 ) ) THEN
            'Between5YearsAnd10Years'
        ELSE
            'Over10Years'
    END                                                                     AS "InitialCreditTerm",
    CASE
        WHEN ( round((BKEFR_#DATE_EXTRACT.dech - BKEFR_#DATE_EXTRACT.dou) / 30) <= 24 ) THEN
            'ShortTerm'
        WHEN ( round((BKEFR_#DATE_EXTRACT.dech - BKEFR_#DATE_EXTRACT.dou) / 30) > 24
               AND ( round((BKEFR_#DATE_EXTRACT.dech - BKEFR_#DATE_EXTRACT.dou) / 30) <= 120 ) ) THEN
            'MiddleTerm'
        ELSE
            'LongTerm'
    END                                                                     AS "CreditTerm",
    'HealthyDebts'                                                          AS "NatureOfGrantedCredit"
    ,
    'NULL'                                                                    AS oustandingcreditype
    ,
    CASE
        WHEN ( trunc(sysdate - BKEFR_#DATE_EXTRACT.dou) < 41) THEN
            'New'
        ELSE
            'Old'
     END                                                                     AS "StateOfContract",
    ROUND(0)                                                                AS "EffectiveCreditRate"
    ,    round(((TO_DATE(:date_fin_periode,'DD/MM/YYYY')) - BKEFR_#DATE_EXTRACT.dou) / 30)                  AS "ContractLifetime"
    ,
    CASE
        WHEN (
            SELECT
                COUNT(*)
            FROM
                bkgrp_#DATE_EXTRACT,
                bkcli
            WHERE
                    bkcli.cli = BKEFR_#DATE_EXTRACT.cli
                AND bkcli.grp = bkgrp_#DATE_EXTRACT.grp
        ) > 0 THEN
            'Yes'
        ELSE
            'No'
    END                                                                     AS "BelongsToGroup",
    (
        SELECT
            bkgrp_#DATE_EXTRACT.nom
        FROM
            bkgrp_#DATE_EXTRACT,
            bkcli
        WHERE
                bkcli.cli = BKEFR_#DATE_EXTRACT.cli
            AND bkcli.grp = bkgrp_#DATE_EXTRACT.grp
    )                                                                       AS "BelongsToGroupName"

,
    BKEFR_#DATE_EXTRACT.cli                                                               AS "CollateralCode"
    ,
    'Other'                                                                 AS "CollateralType",
    'NULL'                                                                    AS "CollateralDescription",
    0                                                                       AS "CollateralValue",
    to_char(BKEFR_#DATE_EXTRACT.dou, 'YYYY-MM-DD')                                        AS "ValuationDate"
  ,
    CASE
        WHEN bkcli.tcli = '1' THEN
            TRIM(BKEFR_#DATE_EXTRACT.cli)
    END                                                                     AS "CustomerCode",
    CASE
        WHEN bkcli.tcli = '1' THEN
            TRIM((bkcli.pre))
    END                                                                     AS "PresentSurname",
    CASE
        WHEN bkcli.tcli = '1' THEN
            TRIM((bkcli.nom))
    END                                                                     AS "FirstName",
    CASE
        WHEN bkcli.tcli = '1' THEN
            TRIM((bkcli.pre))
            || ' '
            || TRIM((bkcli.nom))
    END                                                                     AS "FullName",
    CASE
        WHEN bkcli.tcli = '1' THEN
            TRIM((bkcli.nmer))
    END                                                                     AS "MothersjuindenName",
    CASE
        WHEN bkcli.tcli = '1' THEN
            bkcli.nbenf
    END                                                                     AS "NumberOfChildren",
    CASE
        WHEN bkcli.tcli = '1' THEN
            'NULL'
    END                                                                     AS "ClassificationOfIndividual",
    CASE
        WHEN bkcli.tcli = '1' THEN
            decode(bkcli.sext, 'M', 'Male', 'F', 'Female')
    END                                                                     AS "Gender",
    CASE
        WHEN bkcli.tcli = '1' THEN
            to_char(bkcli.dna, 'YYYY-MM-DD')
    END                                                                     AS "DateOfBirth",
    CASE
        WHEN bkcli.tcli = '1'
             AND TRIM(bkcli.payn) = '958' THEN
            'BJ'
        WHEN bkcli.tcli = '1'
             AND TRIM(bkcli.payn) != '958' THEN
            (
                SELECT
                    TRIM(bknom_#DATE_EXTRACT.lib2)
                FROM
                    bknom_#DATE_EXTRACT
                WHERE
                        TRIM(bknom_#DATE_EXTRACT.cacc) = TRIM(bkcli.payn)
                    AND TRIM(bknom_#DATE_EXTRACT.ctab) = '040'
            )
    END                                                                     AS "CountryOfBirth",
    CASE
        WHEN bkcli.tcli = '1' THEN
            viln
    END                                                                     AS "PlaceOfBirth",
    CASE
        WHEN bkcli.tcli = '1' THEN
            decode(bkcli.sit, 'M', 'Married', 'C', 'Single',
                   'D', 'Divorced', 'V', 'Widowed', 'Other')
    END                                                                     AS "MaritalStatus",
    CASE
        WHEN bkcli.tcli = '1' THEN
            'NULL'
    END                                                                     AS "SocialStatus",
    (
        SELECT
            TRIM(ora_getlib2nom('040', res))
        FROM
            bkcli
        WHERE
            cli = BKEFR_#DATE_EXTRACT.cli
    )                                                                       AS "Residency",
    (
        SELECT
            TRIM(ora_getlib5nom('033', nat))
        FROM
            bkcli
        WHERE
            cli = BKEFR_#DATE_EXTRACT.cli
    )                                                                       AS "Nationality",
    CASE
        WHEN bkcli.tcli = '1' THEN
            'NULL'
    END                                                                     AS "Employment",
    CASE
        WHEN bkcli.tcli = '1' THEN
            'NULL'
    END                                                                     AS "NegativeStatusOfIndividual",
    CASE
        WHEN ora_getseg(BKEFR_#DATE_EXTRACT.cli) IN ( 'P11', 'P12' ) THEN
            'Employee'
        ELSE
            'UnclassifiableWorkers'
    END                                                                     AS "ProfessionalCategory",
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
    END                                                                     AS "PhoneNumber"
	 ,
    '0'                                                                     AS "PaiementIncident"

,
    CASE
        WHEN bkcli.tcli = '2'
             OR bkcli.tcli = '3' THEN
            TRIM(bkcli.cli)
    END                                                                     AS "C_CustomerCode",
    CASE
        WHEN bkcli.tcli = '2'
             OR bkcli.tcli = '3' THEN
            rtrim(ltrim(regexp_replace(TRIM(bkcli.rso), '[-+/\:.,()&"]', '')))
    END                                                                     AS "CompanyName",
    CASE
        WHEN bkcli.tcli = '2'
             OR bkcli.tcli = '3' THEN
            rtrim(ltrim(bkcli.sig))
    END                                                                     AS "TradeName",
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
    END                                                                     AS "LegalForm",
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
    END                                                                     AS "BusinessStatus",
    CASE
        WHEN bkcli.tcli = '2'
             OR bkcli.tcli = '3' THEN
            to_char(bkcli.datc, 'YYYY-MM-DD')
    END                                                                     AS "EstablishmentDate",
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
    END                                                                     AS "IndustrySector",
    (
        SELECT
            TRIM(ora_getlib2nom('040', res))
        FROM
            bkcli
        WHERE
            cli = BKEFR_#DATE_EXTRACT.cli
    )                                                                       AS "Residency",
    (
        SELECT
            TRIM(ora_getlib5nom('033', nat))
        FROM
            bkcli
        WHERE
            cli = BKEFR_#DATE_EXTRACT.cli
    )                                                                       AS "Nationality",
    CASE
        WHEN (
            SELECT
                sig
            FROM
                bkcli
            WHERE
                cli = BKEFR_#DATE_EXTRACT.cli
        ) = ' ' THEN
            substr((
                SELECT
                    rso
                FROM
                    bkcli
                WHERE
                    cli = BKEFR_#DATE_EXTRACT.cli
            ),
                   0,
                   60)
        ELSE
            substr((
                SELECT
                    sig
                FROM
                    bkcli
                WHERE
                    cli = BKEFR_#DATE_EXTRACT.cli
            ),
                   0,
                   60)
    END                                                                     AS "Sigle",
    decode(TRIM(ora_getcatn(BKEFR_#DATE_EXTRACT.cli)), '21100', 'CentralBanks', '21101', 'CentralBanks',
           '21210', '2', '21220',
           'Banks',
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
           ' OtherOrganizations')                                           AS "EconomicStatus",
    '0'                                                                     AS "PaiementIncident",
    '0'                                                                     AS "AnnualSales" ,
    CASE
        WHEN bkcli.tcli = '2'
             OR bkcli.tcli = '3' THEN
            replace(replace(replace(replace(TRIM(nrc), ' '), '-'), '.'), '/')
    END                                                                     AS "RegistrationNumber",

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
    END                                                                     "RegistrationNumberIssuerCountr"
    ,
    CASE
        WHEN bkcli.tcli = '2'
             OR bkcli.tcli = '3' THEN
            replace(replace(TRIM(nidf), ' '), '/')
    END                                                                     AS "TaxNumber",

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
    END                                                                     AS "TaxNumberIssuerCountry"

    ,
    CASE
        WHEN bkcli.tcli = '2'
             OR bkcli.tcli = '3' THEN
            'NULL'
    END                                                                     AS "BCEAONumber",
    CASE
        WHEN bkcli.tcli = '2'
             OR bkcli.tcli = '3' THEN
            'NULL'
    END                                                                     AS "BCEAONumberIssuerCountry"


,
    CASE
        WHEN bkcli.tid IN ( '00001', '50000' )
             AND bkcli.tcli = '1' THEN
            replace(TRIM(bkcli.nid), ' ')
    END                                                                     AS "NationalID",
    CASE
        WHEN bkcli.tid IN ( '00001', '50000' )
             AND bkcli.tcli = '1' THEN
            to_char(bkcli.did, 'YYYY-MM-DD')
    END                                                                     AS "NationalIDIssueDate",
    CASE
        WHEN bkcli.tid IN ( '00001', '50000' )
             AND bkcli.tcli = '1' THEN
            to_char(bkcli.vid, 'YYYY-MM-DD')
    END                                                                     AS "NationalIDExpirationDate",
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
                cli = BKEFR_#DATE_EXTRACT.cli
        ) = 'BJ' THEN
            'BJ'
        WHEN bkcli.tid IN ( '00001', '50000' )
             AND bkcli.tcli = '1'
             AND TRIM(bkcli.payn) != '958' THEN
            (
                SELECT
                    TRIM(bknom_#DATE_EXTRACT.lib2)
                FROM
                    bknom_#DATE_EXTRACT
                WHERE
                        TRIM(bknom_#DATE_EXTRACT.cacc) = TRIM(bkcli.payn)
                    AND TRIM(bknom_#DATE_EXTRACT.ctab) = '040'
            )
    END                                                                     AS "NationalIDIssuerCountry"
	,
    CASE
        WHEN bkcli.tid = '00002'
             AND bkcli.tcli = '1' THEN
            replace(TRIM(bkcli.nid), ' ')
    END                                                                     AS "PassportNumber",
    CASE
        WHEN bkcli.tid = '00002'
             AND bkcli.tcli = '1' THEN
            to_char(bkcli.did, 'YYYY-MM-DD')
    END                                                                     AS "PassportIssueDate",
    CASE
        WHEN bkcli.tid = '00002'
             AND bkcli.tcli = '1' THEN
            to_char(bkcli.vid, 'YYYY-MM-DD')
    END                                                                     AS "PassportExpirationDate",
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
                cli = BKEFR_#DATE_EXTRACT.cli
        ) = 'BJ' THEN
            'BJ'
        WHEN bkcli.tid = '00002'
             AND bkcli.tcli = '1' THEN
            (
                SELECT
                    TRIM(bknom_#DATE_EXTRACT.lib2)
                FROM
                    bknom_#DATE_EXTRACT
                WHERE
                        TRIM(bknom_#DATE_EXTRACT.cacc) = TRIM(bkcli.payn)
                    AND TRIM(bknom_#DATE_EXTRACT.ctab) = '040'
            )
    END                                                                     AS "PassportIssuerCountry"

	,
    CASE
        WHEN bkcli.tid = '00005'
             AND bkcli.tcli = '1' THEN
            replace(TRIM(bkcli.nid), ' ')
    END                                                                     AS "ResidencePermitNumber",
    CASE
        WHEN bkcli.tid = '00005'
             AND bkcli.tcli = '1' THEN
            to_char(bkcli.did, 'YYYY-MM-DD')
    END                                                                     AS "ResidencePermitIssueDate",
    CASE
        WHEN bkcli.tid = '00005'
             AND bkcli.tcli = '1' THEN
            to_char(bkcli.vid, 'YYYY-MM-DD')
    END                                                                     AS "ResidencePermitExpirationDate",
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
                cli = BKEFR_#DATE_EXTRACT.cli
        ) = 'BJ' THEN
            'BJ'
        WHEN bkcli.tid = '00005'
             AND bkcli.tcli = '1' THEN
            (
                SELECT
                    TRIM(bknom_#DATE_EXTRACT.lib2)
                FROM
                    bknom_#DATE_EXTRACT
                WHERE
                        TRIM(bknom_#DATE_EXTRACT.cacc) = TRIM(bkcli.payn)
                    AND TRIM(bknom_#DATE_EXTRACT.ctab) = '040'
            )
    END                                                                     AS "ResidencePermitIssuerCountry"

	,
    CASE
        WHEN bkcli.tid = '00009'
             AND bkcli.tcli = '1' THEN
            'NULL'
    END                                                                     AS "DrivingLicenseNumber",
    CASE
        WHEN bkcli.tid = '00009'
             AND bkcli.tcli = '1' THEN
            'NULL'
    END                                                                     AS "DrivingLicenseIssueDate",
    CASE
        WHEN bkcli.tid = '00009'
             AND bkcli.tcli = '1' THEN
            'NULL'
    END                                                                     AS "DrivingLicenseExpirationDate",
    CASE
        WHEN bkcli.tid = '00009'
             AND bkcli.tcli = '1'
             AND TRIM(bkcli.payn) = '958' THEN
            'BJ'
        WHEN bkcli.tid = '00009'
             AND bkcli.tcli = '1' THEN
            'NULL'
    END                                                                     AS "DrivingLicenseIssuerCountry"

	,
    CASE
        WHEN bkcli.tid = '00007'
             AND bkcli.tcli = '1' THEN
            replace(TRIM(bkcli.nid), ' ')
    END                                                                     AS "ConsularCard",
    CASE
        WHEN bkcli.tid = '00007'
             AND bkcli.tcli = '1' THEN
            to_char(bkcli.did, 'YYYY-MM-DD')
    END                                                                     AS "ConsularCardIssueDate",
    CASE
        WHEN bkcli.tid = '00007'
             AND bkcli.tcli = '1' THEN
            to_char(bkcli.vid, 'YYYY-MM-DD')
    END                                                                     AS "ConsularCardExpirationDate",
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
                cli = BKEFR_#DATE_EXTRACT.cli
        ) = 'BJ' THEN
            'BJ'
        WHEN bkcli.tid = '00007'
             AND bkcli.tcli = '1' THEN
            (
                SELECT
                    TRIM(bknom_#DATE_EXTRACT.lib2)
                FROM
                    bknom_#DATE_EXTRACT
                WHERE
                        TRIM(bknom_#DATE_EXTRACT.cacc) = TRIM(bkcli.payn)
                    AND TRIM(bknom_#DATE_EXTRACT.ctab) = '040'
            )
    END                                                                     AS "ConsularCardIssuerCountry"

,
    CASE
        WHEN ( bkcli.tid IN ( '00008', '00010', '00097', '00098', '00012',
                              '00013', '00014', '00003', '00004',
                              '00006',
                              '00011' )
               AND bkcli.tcli = '1' ) THEN
            replace(TRIM(bkcli.nid), ' ')
    END                                                                     AS "IDDocumentNumber",
    CASE
        WHEN ( bkcli.tid IN ( '00008', '00010', '00097', '00098', '00012',
                              '00013', '00014', '00003', '00004',
                              '00006',
                              '00011' )
               AND bkcli.tcli = '1' ) THEN
            to_char(bkcli.did, 'YYYY-MM-DD')
    END                                                                     AS "IDDocumentIssueDate",
    CASE
        WHEN ( bkcli.tid IN ( '00008', '00010', '00097', '00098', '00012',
                              '00013', '00014', '00003', '00004',
                              '00006',
                              '00011' )
               AND bkcli.tcli = '1' ) THEN
            to_char(bkcli.vid, 'YYYY-MM-DD')
    END                                                                     AS "IDDocumentExpirationDate",
    CASE
        WHEN ( bkcli.tid IN ( '00008', '00010', '00097', '00098', '00012',
                              '00013', '00014', '00003', '00004',
                              '00006',
                              '00011' )
               AND bkcli.tcli = '1' )
             AND TRIM(bkcli.payn) = '958' THEN
            'BJ'
        WHEN ( bkcli.tid IN ( '00008', '00010', '00097', '00098', '00012',
                              '00013', '00014', '00003', '00004',
                              '00006',
                              '00011' )
               AND bkcli.tcli = '1' )
             AND (
            SELECT
                TRIM(ora_getlib5nom('033', nat))
            FROM
                bkcli
            WHERE
                cli = BKEFR_#DATE_EXTRACT.cli
        ) = 'BJ' THEN
            'BJ'
        WHEN ( bkcli.tid IN ( '00008', '00010', '00097', '00098', '00012',
                              '00013', '00014', '00003', '00004',
                              '00006',
                              '00011' )
               AND bkcli.tcli = '1' ) THEN
            (
                SELECT
                    TRIM(bknom_#DATE_EXTRACT.lib2)
                FROM
                    bknom_#DATE_EXTRACT
                WHERE
                        TRIM(bknom_#DATE_EXTRACT.cacc) = TRIM(bkcli.payn)
                    AND TRIM(bknom_#DATE_EXTRACT.ctab) = '040'
            )
    END                                                                     AS "IDDocumentIssuerCountry",
    CASE
        WHEN ( bkcli.tid IN ( '00008', '00010', '00097', '00098', '00012',
                              '00013', '00014', '00003', '00004',
                              '00006',
                              '00011' )
               AND bkcli.tcli = '1' ) THEN
            'ONI'
        WHEN bkcli.tid IN ( '00008' )
             AND bkcli.tcli = '1' THEN
            'MINISTERE DEFENSE'
    END                                                                     AS "IDDocumentIssueAuthority"

,
    CASE
        WHEN ( rtrim(ltrim(bkadcli.bpos))
               || ' '
               || rtrim(ltrim(bkadcli.ville)) ) IS NOT NULL THEN
            rtrim(ltrim(bkadcli.bpos))
    END                                                                     AS "POBox",
    CASE
        WHEN rtrim(ltrim(bkadcli.adr2)) IS NOT NULL THEN
            rtrim(ltrim(bkadcli.adr2))
    END                                                                     AS "Street",
    CASE
        WHEN rtrim(ltrim(bkadcli.ville)) IS NOT NULL THEN
            rtrim(ltrim(bkadcli.ville))
    END                                                                     AS "City",
    'NULL'                                                                    AS "State",
    (
        SELECT
            TRIM(bknom_#DATE_EXTRACT.lib2)
        FROM
            bknom_#DATE_EXTRACT
        WHERE
                TRIM(bknom_#DATE_EXTRACT.cacc) = TRIM(bkadcli.cpay)
            AND TRIM(bknom_#DATE_EXTRACT.ctab) = '040'
    )                                                                       AS "Country",
    CASE
        WHEN rtrim(ltrim(bkadcli.adr1)) IS NOT NULL THEN
            rtrim(ltrim(bkadcli.adr1))
    END                                                                     AS "AddressLine"

,
    'NULL'                                                                    AS "SA_POBox",
    'NULL'                                                                    AS "SA_Street",
    'NULL'                                                                    AS "SA_City",
    'NULL'                                                                    AS "SA_State",
    'NULL'                                                                    AS "SA_Country",
    'NULL'                                                                    AS "SA_AddressLine"
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
    END                                                                     AS "MobilePhone",
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
    END                                                                     AS "FixedLine",
    rtrim(ltrim(bkadcli.email))                                             AS "Email",
    'NULL'                                                                    AS "WebPage",
    'NULL'                                                                    AS "Fax"

,
    TRIM(BKEFR_#DATE_EXTRACT.cli)                                                         AS "CustomerCodeRole",
    'MainDebtor'                                                            AS "RoleOfCustomer"
FROM
    bkcli
    LEFT OUTER JOIN (
      SELECT 'BKEFR' TAB, BKEFR_#DATE_EXTRACT.*
      FROM BKEFR_#DATE_EXTRACT
      WHERE (
          BKEFR_#DATE_EXTRACT.VIE = '0'
          OR
          (BKEFR_#DATE_EXTRACT.VIE = '2' AND TO_CHAR(BKEFR_#DATE_EXTRACT.DECH)  BETWEEN :date_debut_periode AND :date_fin_periode)
      )
      UNION
      SELECT 'BKHISEFR' TAB, BKHISEFR_#DATE_EXTRACT.*
      FROM BKHISEFR_#DATE_EXTRACT
      WHERE (BKHISEFR_#DATE_EXTRACT.VIE = '9' AND TO_CHAR(BKHISEFR_#DATE_EXTRACT.DECH)  BETWEEN :date_debut_periode AND :date_fin_periode)
    ) BKEFR_#DATE_EXTRACT ON bkcli.cli = BKEFR_#DATE_EXTRACT.cli
    LEFT OUTER JOIN DBEDI.BKTELCLI ON bkcli.cli = DBEDI.BKTELCLI.cli
    LEFT OUTER JOIN bkadcli ON bkcli.cli = bkadcli.cli
WHERE
        bkadcli.typ = 'D'
     AND (BKEFR_#DATE_EXTRACT.type) IN ( '150','100')
    AND ( ( TO_CHAR(BKEFR_#DATE_EXTRACT.dou) <= :date_fin_periode AND TO_CHAR(BKEFR_#DATE_EXTRACT.dech) >= :date_fin_periode )
          OR ( TO_CHAR(BKEFR_#DATE_EXTRACT.dech) BETWEEN :date_debut_periode AND :date_fin_periode ) )
              AND 'E' || BKEFR_#DATE_EXTRACT.neff IN (SELECT DISTINCT reference FROM BIC_DECLARATION_EN_COURS WHERE STATUT = 'Open' AND MOIS_ANNEE  = :MOIS_ANNEE)
