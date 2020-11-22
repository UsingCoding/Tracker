export default class ServerApi
{
    /**
     *
     * @param {String} issueCode
     */
    async getIssue(issueCode)
    {
        let response = await fetch('/api/issue/' + issueCode, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json;charset=utf-8'
            }
        })
        return await response.json();
    }

    async updateIssue(props)
    {
        let response = await fetch('/api/issue', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json;charset=utf-8'
                },
                body: JSON.stringify({
                    "issue_id": props.issue_id,
                    "name": props.title,
                    "description": props.description,
                    "fields": {
                        "user_id": props.user_id,
                        "project_id": props.project_id
                    }
                })
            })
    
            return await response.json();
            // if(result === 1){
    
            // }
            // else {
            //     alert("Ooops, something went wrong =(");
            // }
    }

    async createIssue(props)
    {
        let response = await fetch('/api/issue/create', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json;charset=utf-8'
            },
            body: JSON.stringify({
                "name": props.title,
                "description": props.description,
                "fields": {
                    "user_id": props.fields.user_id,
                    "project_id": props.fields.project_id
                }
            })
        })
        return await response.json()
    }

    async getIssueList()
    {
        let response = await fetch('/api/issue/search',{
            method: 'POST',
            headers: {
                'Content-Type': 'application/json;charset=utf-8'
            },
            body: JSON.stringify({
                'search_query': ''
            })
        })
        return await response.json();
    }
}