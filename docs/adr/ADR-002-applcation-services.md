# ADR-002 — Application Services

## Statut
Accepté

## Contexte
Les use cases de Zeroframe nécessitent d'orchestrer plusieurs opérations :
récupérer un agrégat, exécuter une action métier, persister et dispatcher
les events. Symfony Messenger permet de brancher ces use cases sur un bus
de commandes avec le pattern Command/Handler, mais cette complexité
supplémentaire n'est pas utile pour le moment.

## Décision
Utiliser des Application Services simples pour orchestrer les use cases.
Symfony Messenger sera branché en Phase 2 quand le besoin d'async sera réel.

## Conséquences
+ Moins de couches d'abstraction — code plus simple et maintenable
+ Pas de dépendance à Symfony Messenger dès le départ (YAGNI)
- Pas d'async natif — les use cases s'exécutent de façon synchrone
- Migration vers Command/Handler à prévoir en Phase 2