resource "aws_db_instance" "rret-db" {
  engine                  = "MySQL"
  engine_version          = "5.7.30"
  identifier              = "rret-db"
  name                    = "rret_db"
  username                = var.aws_rds_username
  password                = var.aws_rds_password
  instance_class          = "db.t2.micro"
  storage_type            = "gp2"
  allocated_storage       = 20
  max_allocated_storage   = 25
  port                    = 3306
  backup_retention_period = 7
  copy_tags_to_snapshot   = true
  skip_final_snapshot     = true
  vpc_security_group_ids  = [aws_security_group.rds-sg.id]
  parameter_group_name    = aws_db_parameter_group.db-pg.name
  db_subnet_group_name    = aws_db_subnet_group.rret-db-sg.name
  availability_zone       = "ap-northeast-1a"
}