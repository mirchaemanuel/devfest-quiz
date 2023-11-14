# TODO

## Guest can
- see home page (page) ✅
- see ranking result in home page (page) ✅

## Members can
- log in (page) ✅
- see list of quizzes (page) ✅
- see quiz details (page) ✅
- take a quiz (page) ✅
- see quiz result (page) ✅

```mermaid
graph TD
    subgraph K8s_Cluster[Kubernetes Cluster]
        Ingress[Ingress Controller]
        Service[Service]
        Pods[Pods]
        Deployment[Deployment]
    end

    subgraph Laravel_App[Laravel Application]
        Laravel[Laravel Framework]
        Queue[Queue Service]
        Cache[Cache Service]
    end

    subgraph DB_Cluster[Database Cluster]
        DBMaster[(DB Master)]
        DBSlave[(DB Slave)]
    end

    subgraph External_Services[External Services]
        Storage[Storage Service]
        Email[Email Service]
    end

    Laravel_App -->|Deployed in| Pods
    Pods -->|Managed by| Deployment
    Deployment -->|Exposed by| Service
    Service -->|Routed through| Ingress
    Ingress -->|Receives traffic| User[User]

    Laravel -->|Interacts with| DBMaster
    Laravel -->|Reads from| DBSlave
    Laravel --> Queue
    Laravel --> Cache

    Laravel -->|Uses| Storage
    Laravel -->|Sends emails via| Email

    DBMaster -->|Replicates to| DBSlave
```
