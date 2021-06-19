# aspiretasks
loanrepayment api using laravel
http://127.0.0.1:8000/api/loan-repayment is the url to test the api...download the aspiretasks and place under htdocs folder xamp/lamp/laragon webservers...

post data for the api is:
{
    "loan_amount": enter the loan,
    "interest_rate": interest rate per annum,
    "no_weekly_terms": in how many weeks the loan should be repaid
}

sample post data should be as follows:
{
    "loan_amount": "25000",
    "interest_rate": "10",
    "no_weekly_terms": "4"
}

the response of the api is as follows:

{
    "inputs": {
        "loan_amount": "25000",
        "interest_rate": "10",
        "weekly_terms": "4"
    },
    "loan_summary": {
        "total_pay": 25120.30776611601,
        "total_interest": 120.30776611600959
    },
    "weekly_payment_schedule": [
        {
            "payment": 6280.076941529002,
            "interest": 48.07692307692308,
            "principal": 6232.0000184520795,
            "balance": 18767.99998154792
        },
        {
            "payment": 6280.076941528841,
            "interest": 36.092307656822925,
            "principal": 6243.984633872018,
            "balance": 12524.015347675902
        },
        {
            "payment": 6280.076941528953,
            "interest": 24.084644899376737,
            "principal": 6255.992296629576,
            "balance": 6268.023051046326
        },
        {
            "payment": 6280.076941529297,
            "interest": 12.053890482781398,
            "principal": 6268.023051046515,
            "balance": 0
        }
    ]
}
