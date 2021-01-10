import axios from 'axios';

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
                "fields": props.fields
            })
        })
    
        return await response.json();
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
                "fields": props.fields
            })
        })
        return await response.json();
    }

    async deleteIssue(issue_id)
    {
        let response = await fetch('/api/issue/delete', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json;charset=utf-8'
            },
            body: JSON.stringify({
                'issue_id': issue_id
            })
        })

        return await response;
    }

    async getIssueList(props)
    {
        let response = await fetch('/api/issue/search',{
            method: 'POST',
            headers: {
                'Content-Type': 'application/json;charset=utf-8'
            },
            body: JSON.stringify({
                'search_query': props.search_query,
                'project_id': props.project_id
            })
        })
        return await response.json();
    }

    async createProject(props)
    {
        let response = await fetch('/api/project/create', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json;charset=utf-8'
            },
            body: JSON.stringify({
                'name': props.name,
                'nameId': props.nameId,
                'description': props.description
            })
        })
        return await response.json();
    }

    async getProject(project_id)
    {
        let response = await fetch('/api/project/' + project_id, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json;charset=utf-8'
            }
        });

        return await response.json();
    }

    async getProjectsList()
    {
        let response = await fetch('/api/projects', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json;charset=utf-8'
            }
        });

        return await response.json();
    }

    async updateProject(props)
    {
        let response = await fetch('/api/project/edit', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json;charset=utf-8'
            },
            body: JSON.stringify({
                'name': props.name,
                'project_id': props.project_id,
                'new_owner_id': props.new_owner_id,
                'description': props.description
            })
        });

        return await response;
    }

    async deleteProject(project_id)
    {
        let response = await fetch('/api/project/delete', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json;charset=utf-8'
            },
            body: JSON.stringify({
                'project_id': project_id
            })
        });

        return await response;
    }

    async getUsersList()
    {

        let response = await fetch('/api/users', {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json;charset=utf-8'
            }
        });

        return await response.json();
    }

    async createUser(props)
    {
        let response = {};
        await axios.post('/api/user/add',
        props,
        {
            headers: {
                'Content-Type': 'multipart/form-data' 
            }
        }).then(function() {
            response.result = 1;
            
        })
        .catch(function() {
            response.result = 0;
        })
        return response;

    }

    async getUser(user_id)
    {
        let response = await fetch('/api/user', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json;charset=utf-8'
            },
            body: JSON.stringify({
                'user_id': user_id 
            })
        });

        return await response.json();
    }

    async editUser(props)
    {
        let response = {}
        await axios.post('/api/user/edit',
        props,
        {
            headers: {
                'Content-Type': 'multipart/form-data' 
            }
        }).then(function() {
            response.result = 1;
        })
        .catch(function() {
            response.result = 0;
        })
        return response;
    }

    async deleteUser(user_id)
    {
        let response = await fetch('/api/user/delete', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json;charset=utf-8'
            },
            body: JSON.stringify({
                'user_id': user_id
            })
        });

        return await response;
    }

    async getFieldsList(projectId)
    {
        let response = await fetch('/api/issue-field/list/' + projectId, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json;charset=utf-8'
            }
        });

        return await response.json();
    }

    async addField(props)
    {
        let response = await fetch('/api/issue-field/add', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json;charset=utf-8'
            },
            body: JSON.stringify({
                'name': props.name,
                'type': props.type,
                'project_id': props.project_id
            })
        });

        return await response.json();
    }

    async editField(props)
    {
        let response = await fetch('/api/issue-field/edit', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json;charset=utf-8'
            },
            body: JSON.stringify({
                'name': props.name,
                'type': props.type,
                'issue_field_id': props.issue_field_id
            })
        });
        
        return await response;
    }

    async deleteField(field_id)
    {
        let response = await fetch('/api/issue-field/delete', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json;charset=utf-8'
            },
            body: JSON.stringify({
                'issue_field_id': field_id
            })
        });
        
        return await response;
    }

    async addMember(props)
    {
        let response = await fetch('/api/team-member/add', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json;charset=utf-8'
            },
            body: JSON.stringify({
                'project_id': props.project_id,
                'user_id': props.user_id
            })
        });
        
        return await response;
    }

    async removeMember(team_member_id)
    {
        let response = await fetch('/api/team-member/remove', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json;charset=utf-8'
            },
            body: JSON.stringify({
                'team_member_id': team_member_id
            })
        });
        
        return await response;
    }

    async getMembersList(project_id)
    {  
        let response = await fetch('/api/team-members', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json;charset=utf-8'
            },
            body: JSON.stringify({
                'project_id': project_id
            })
        });
        
        return await response.json();
    }

    async getUsersToAddList(project_id)
    {
        let response = await fetch('/api/team/users-to-add', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json;charset=utf-8'
            },
            body: JSON.stringify({
                'project_id': project_id
            })
        })

        return await response.json();
    }

    async createComment(props)
    {
        let response = await fetch('/api/issue/comment/add', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json;charset=utf-8'
            },
            body: JSON.stringify({
                'user_id': props.user_id,
                'issue_id': props.issue_id,
                'content': props.content
            })
        });

        return await response.json();
    }

    async editComment(props)
    {
        let response = await fetch('/api/issue/comment/edit', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json;charset=utf-8'
            },
            body: JSON.stringify({
                'comment_id': props.comment_id,
                'content': props.content
            })
        })

        return response;
    }

    async deleteComment(comment_id)
    {  
        let response = await fetch('/api/issue/comment/delete', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json;charset=utf-8'
            },
            body: JSON.stringify({
                'comment_id': comment_id
            })
        });
        
        return await response;
    }

    async getCommentsForIssue(issue_id)
    {
        let response = await fetch('/api/issue/comments', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json;charset=utf-8'
            },
            body: JSON.stringify({
                'issue_id': issue_id
            })
        });

        return await response.json();
    }
}