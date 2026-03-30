# Pipelines

Authentication is implemented as a configurable pipeline of steps.

Pipeline configuration lives in `config/auth_pipeline.php`.

Next phase adds:

- Pipeline engine service
- Step contracts
- Built-in pipelines (password/otp/social)

